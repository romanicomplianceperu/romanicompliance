<?php

namespace App\Support\Ofac;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Listas de sanciones de OFAC (Departamento del Tesoro de EE. UU.): la lista SDN y la
 * lista consolidada (no SDN). Descarga los archivos oficiales, arma un índice compacto
 * en storage/app/ofac y busca con tolerancia a tildes, mayúsculas, orden de palabras y
 * errores de tipeo (similitud Jaro-Winkler por palabra, como el buscador oficial).
 *
 * Si la descarga falla, se usa la copia incluida en database/content/ofac.
 */
class OfacList
{
    public const SOURCE = 'https://sanctionslistservice.ofac.treas.gov/api/PublicationPreview/exports/';

    public const FILES = [
        'S' => ['SDN.CSV', 'ALT.CSV', 'ADD.CSV'],
        'C' => ['CONS_PRIM.CSV', 'CONS_ALT.CSV', 'CONS_ADD.CSV'],
    ];

    /** Se actualiza cada 12 horas (OFAC publica cambios varias veces por semana). */
    public const MAX_AGE_HOURS = 12;

    private const STOPWORDS = ['de', 'del', 'la', 'las', 'los', 'el', 'y', 'e', 'the', 'of', 'and', 'sa', 'sac', 'srl', 'ltd', 'llc', 'inc', 'co', 'corp', 'company', 'limited', 'cia', 'ltda', 'al', 'el'];

    private static ?array $index = null;

    private static array $buckets = [];

    // ── Rutas ───────────────────────────────────────────────────────────────

    public static function dir(): string
    {
        return storage_path('app/ofac');
    }

    private static function indexPath(): string
    {
        return self::dir().'/index.ser';
    }

    /** Fichas completas repartidas en 128 archivos: solo se leen las de los resultados. */
    private const BUCKETS = 128;

    private static function bucketPath(int $id, ?string $dir = null): string
    {
        return ($dir ?? self::dir().'/fichas').'/'.($id % self::BUCKETS).'.ser';
    }

    private static function snapshotDir(): string
    {
        return database_path('content/ofac');
    }

    // ── Estado y actualización ──────────────────────────────────────────────

    public static function meta(): array
    {
        $idx = self::index();

        return $idx['meta'] ?? [];
    }

    public static function isStale(): bool
    {
        $meta = self::meta();
        $built = $meta['built_at'] ?? null;
        // Armado desde la copia incluida: se actualiza con OFAC en cuanto se pueda.
        if (($meta['source'] ?? '') === 'copia') {
            $tried = Cache::get('ofac-last-try');
            return ! $tried || now()->diffInMinutes(\Carbon\Carbon::parse($tried), true) >= 30;
        }

        return ! $built || now()->diffInHours(\Carbon\Carbon::parse($built), true) >= self::MAX_AGE_HOURS;
    }

    /** Asegura que exista un índice (la primera vez lo arma con la descarga o la copia incluida). */
    public static function ensure(): void
    {
        if (! is_file(self::indexPath())) {
            // Primera vez: se arma rápido con la copia incluida y luego se actualiza en segundo plano.
            if (! (self::sync(allowSnapshot: true, snapshotOnly: true)['ok'] ?? false)) {
                self::sync(allowSnapshot: true);
            }
        }
    }

    /** Programa una actualización al terminar la respuesta (el visitante no espera). */
    public static function refreshInBackgroundIfStale(): void
    {
        if (! self::isStale()) {
            return;
        }
        app()->terminating(function () {
            $lock = Cache::lock('ofac-sync', 600);
            if ($lock->get()) {
                rescue(fn () => Cache::put('ofac-last-try', now()->toIso8601String(), now()->addDay()), null, false);
                try {
                    self::sync(allowSnapshot: false);
                } finally {
                    $lock->release();
                }
            }
        });
    }

    /** Descarga las listas oficiales y rearma el índice. Devuelve un resumen. */
    public static function sync(bool $allowSnapshot = true, bool $snapshotOnly = false): array
    {
        @set_time_limit(180);
        // Armar el índice usa ~110 MB: se pide más memoria si el servidor lo permite.
        if (self::bytes((string) ini_get('memory_limit')) < 512 * 1048576) {
            @ini_set('memory_limit', '512M');
        }
        $raw = [];
        $source = 'ofac';
        $published = null;
        try {
            if ($snapshotOnly) {
                throw new \RuntimeException('primera carga desde la copia incluida');
            }
            foreach (self::FILES as $list => $files) {
                foreach ($files as $file) {
                    $res = Http::timeout(90)->retry(2, 2000)->withHeaders(['User-Agent' => 'RomaniCompliance-Buscador/1.0'])->get(self::SOURCE.$file);
                    if (! $res->successful() || strlen($res->body()) < 100) {
                        throw new \RuntimeException("Descarga fallida de {$file} ({$res->status()})");
                    }
                    $raw[$file] = $res->body();
                    if ($file === 'SDN.CSV' && $res->header('Last-Modified')) {
                        $published = \Carbon\Carbon::parse($res->header('Last-Modified'))->toIso8601String();
                    }
                }
            }
        } catch (\Throwable $e) {
            if (! $snapshotOnly) {
                Log::warning('OFAC: no se pudo descargar la lista: '.$e->getMessage());
            }
            if (! $allowSnapshot && is_file(self::indexPath())) {
                return ['ok' => false, 'error' => $e->getMessage()];
            }
            $raw = self::readSnapshot();
            $source = 'copia';
            $published = json_decode((string) @file_get_contents(self::snapshotDir().'/meta.json'), true)['published_at'] ?? null;
            if (! $raw) {
                return ['ok' => false, 'error' => $e->getMessage()];
            }
        }

        [$index, $entities] = self::build($raw, ['source' => $source, 'published_at' => $published, 'built_at' => now()->toIso8601String()]);
        if (! is_dir(self::dir())) {
            @mkdir(self::dir(), 0775, true);
        }
        // Fichas en una carpeta nueva; luego se cambia de golpe para no dejar mezclas.
        $newDir = self::dir().'/fichas-'.uniqid();
        @mkdir($newDir, 0775, true);
        $buckets = [];
        foreach ($entities as $id => $e) {
            $buckets[$id % self::BUCKETS][$id] = $e;
        }
        foreach ($buckets as $b => $list) {
            file_put_contents($newDir.'/'.$b.'.ser', serialize($list));
        }
        $old = self::dir().'/fichas';
        $trash = is_dir($old) ? self::dir().'/fichas-old-'.uniqid() : null;
        if ($trash) {
            rename($old, $trash);
        }
        rename($newDir, $old);
        $tmp = self::indexPath().'.tmp';
        file_put_contents($tmp, serialize($index));
        rename($tmp, self::indexPath());
        if ($trash) {
            array_map('unlink', glob($trash.'/*.ser') ?: []);
            @rmdir($trash);
        }
        self::$index = $index;
        self::$buckets = [];

        return ['ok' => true] + $index['meta'];
    }

    private static function bytes(string $v): int
    {
        $v = trim($v);
        if ($v === '' || $v === '-1') {
            return PHP_INT_MAX;
        }
        $n = (int) $v;

        return match (strtolower(substr($v, -1))) { 'g' => $n * 1073741824, 'm' => $n * 1048576, 'k' => $n * 1024, default => $n };
    }

    private static function readSnapshot(): array
    {
        $raw = [];
        foreach (array_merge(...array_values(self::FILES)) as $file) {
            $path = self::snapshotDir().'/'.$file.'.gz';
            if (! is_file($path)) {
                return [];
            }
            $raw[$file] = gzdecode((string) file_get_contents($path));
        }

        return $raw;
    }

    // ── Armado del índice ───────────────────────────────────────────────────

    private static function csv(string $body): array
    {
        $rows = [];
        $fh = fopen('php://temp', 'r+');
        fwrite($fh, $body);
        rewind($fh);
        while (($r = fgetcsv($fh, 0, ',', '"', '')) !== false) {
            if (! isset($r[1])) {
                continue;
            }
            $rows[] = array_map(fn ($v) => self::clean($v), $r);
        }
        fclose($fh);

        return $rows;
    }

    private static function clean(?string $v): string
    {
        $v = trim((string) $v);
        if ($v === '-0-') {
            return '';
        }
        // Los archivos de OFAC vienen en Windows-1252 / Latin-1.
        if (! mb_check_encoding($v, 'UTF-8')) {
            $v = mb_convert_encoding($v, 'UTF-8', 'Windows-1252');
        }

        return $v;
    }

    private static function build(array $raw, array $meta): array
    {
        $entities = [];
        $types = ['individual' => 'i', 'vessel' => 'v', 'aircraft' => 'a'];

        foreach (self::FILES as $list => [$prim, $alt, $add]) {
            foreach (self::csv($raw[$prim]) as $r) {
                $id = (int) $r[0];
                if (! $id) {
                    continue;
                }
                $entities[$id] = [
                    'id' => $id,
                    'n' => $r[1],
                    't' => $types[strtolower($r[2] ?? '')] ?? 'e',
                    'l' => $list,
                    'p' => array_values(array_filter(array_map('trim', explode(']', str_replace('[', ']', $r[3] ?? ''))))),
                    'ti' => $r[4] ?? '',
                    'cs' => $r[5] ?? '',
                    'vt' => $r[6] ?? '',
                    'vf' => $r[9] ?? '',
                    'vo' => $r[10] ?? '',
                    'r' => rtrim($r[11] ?? '', '.'),
                    'al' => [],
                    'ad' => [],
                    'co' => [],
                ];
            }
            foreach (self::csv($raw[$alt]) as $r) {
                $id = (int) $r[0];
                if (isset($entities[$id]) && ($r[3] ?? '') !== '') {
                    $entities[$id]['al'][] = [$r[2] ?? 'aka', $r[3]];
                }
            }
            foreach (self::csv($raw[$add]) as $r) {
                $id = (int) $r[0];
                if (! isset($entities[$id])) {
                    continue;
                }
                $parts = array_values(array_filter([$r[2] ?? '', $r[3] ?? '', $r[4] ?? '']));
                if ($parts) {
                    $entities[$id]['ad'][] = implode(', ', $parts);
                }
                if (($r[4] ?? '') !== '' && ! in_array($r[4], $entities[$id]['co'], true)) {
                    $entities[$id]['co'][] = $r[4];
                }
            }
        }

        $programs = [];
        $countries = [];
        foreach ($entities as $e) {
            foreach ($e['p'] as $p) {
                $programs[$p] = ($programs[$p] ?? 0) + 1;
            }
            foreach ($e['co'] as $c) {
                $countries[$c] = ($countries[$c] ?? 0) + 1;
            }
        }
        arsort($programs);
        ksort($countries);
        $pIdx = array_flip(array_keys($programs));
        $cIdx = array_flip(array_keys($countries));

        // Índice compacto: cada nombre es una línea de texto y cada palabra apunta a sus
        // nombres con una cadena binaria (así la búsqueda usa poca memoria).
        // nombre = id \t principal \t tipo \t lista \t programas \t países \t compacto \t palabras \t original
        $names = [];
        $tokens = [];
        foreach ($entities as $id => $e) {
            $progs = implode(',', array_map(fn ($p) => $pIdx[$p], $e['p']));
            $ctrs = implode(',', array_map(fn ($c) => $cIdx[$c], $e['co']));
            foreach (array_merge([['', $e['n']]], $e['al']) as [$kind, $name]) {
                $toks = self::tokens($name);
                if (! $toks) {
                    continue;
                }
                $k = count($names);
                $names[] = implode("\t", [$id, $kind === '' ? 1 : 0, $e['t'], $e['l'], $progs, $ctrs, str_replace(' ', '', self::normalize($name)), implode(' ', $toks), $name]);
                foreach (array_unique($toks) as $t) {
                    $tokens[$t] = ($tokens[$t] ?? '').pack('V', $k);
                }
            }
        }

        $meta += [
            'entities' => count($entities),
            'sdn' => count(array_filter($entities, fn ($e) => $e['l'] === 'S')),
            'cons' => count(array_filter($entities, fn ($e) => $e['l'] === 'C')),
            'names' => count($names),
        ];

        return [
            ['meta' => $meta, 'names' => $names, 'tokens' => $tokens, 'programs' => $programs, 'countries' => array_keys($countries)],
            $entities,
        ];
    }

    // ── Búsqueda ────────────────────────────────────────────────────────────

    public static function index(): array
    {
        if (self::$index === null) {
            $path = self::indexPath();
            self::$index = is_file($path) ? (unserialize((string) file_get_contents($path)) ?: []) : [];
        }

        return self::$index;
    }

    public static function entity(int $id): ?array
    {
        $b = $id % self::BUCKETS;
        if (! isset(self::$buckets[$b])) {
            $path = self::bucketPath($id);
            self::$buckets[$b] = is_file($path) ? (unserialize((string) file_get_contents($path)) ?: []) : [];
        }

        return self::$buckets[$b][$id] ?? null;
    }

    public static function normalize(string $s): string
    {
        $s = Str::lower(Str::ascii($s));
        $s = preg_replace('/[^a-z0-9]+/', ' ', $s);

        return trim(preg_replace('/\s+/', ' ', $s));
    }

    /** Palabras significativas de un nombre (sin artículos ni formas societarias). */
    public static function tokens(string $s): array
    {
        $all = array_values(array_filter(explode(' ', self::normalize($s)), 'strlen'));
        $kept = array_values(array_filter($all, fn ($t) => ! in_array($t, self::STOPWORDS, true)));

        return $kept ?: $all;
    }

    /**
     * @param  array{type?:string,list?:string,program?:string,country?:string,min?:int,limit?:int}  $f
     */
    public static function search(string $query, array $f = []): array
    {
        $idx = self::index();
        $q = self::tokens($query);
        if (! $q || ! $idx) {
            return [];
        }
        $min = max(50, min(100, (int) ($f['min'] ?? 85))) / 100;
        $limit = (int) ($f['limit'] ?? 50);

        // 1) Palabras del diccionario parecidas a cada palabra buscada.
        $cand = [];
        $tokenSim = [];
        foreach (array_unique($q) as $qt) {
            $ql = strlen($qt);
            foreach ($idx['tokens'] as $t => $packed) {
                $t = (string) $t;
                $tl = strlen($t);
                if (abs($tl - $ql) > max(2, (int) ceil($ql * 0.34))) {
                    continue;
                }
                $s = $t === $qt ? 1.0 : self::jaroWinkler($qt, $t);
                if ($s >= 0.8) {
                    // Una palabra parecida vale algo menos que una idéntica.
                    $tokenSim[$qt][$t] = $s >= 1.0 ? 1.0 : $s - (1 - $s) * 0.3;
                    foreach (unpack('V*', $packed) as $k) {
                        $cand[$k] = true;
                    }
                }
            }
        }
        // También nombres que contienen la búsqueda tal cual, sin espacios.
        $joined = str_replace(' ', '', self::normalize($query));
        if (strlen($joined) >= 5) {
            foreach ($idx['names'] as $k => $line) {
                if (! isset($cand[$k]) && str_contains(explode("\t", $line, 8)[6], $joined)) {
                    $cand[$k] = true;
                }
            }
        }

        $pCode = ! empty($f['program']) ? array_search($f['program'], array_keys($idx['programs']), true) : null;
        $cCode = ! empty($f['country']) ? array_search($f['country'], $idx['countries'], true) : null;

        // 2) Puntaje de cada nombre candidato; se queda el mejor por entidad.
        $best = [];
        foreach (array_keys($cand) as $k) {
            [$id, $primary, $type, $list, $progs, $ctrs, $compact, $toks, $display] = explode("\t", $idx['names'][$k]);
            if ((! empty($f['type']) && $type !== $f['type']) || (! empty($f['list']) && $list !== $f['list'])) {
                continue;
            }
            if ($pCode !== null && ($pCode === false || ! in_array((string) $pCode, explode(',', $progs), true))) {
                continue;
            }
            if ($cCode !== null && ($cCode === false || ! in_array((string) $cCode, explode(',', $ctrs), true))) {
                continue;
            }
            $score = self::score($q, explode(' ', $toks), $tokenSim, $joined, $compact);
            if ($score < $min) {
                continue;
            }
            $id = (int) $id;
            if (! isset($best[$id]) || $score > $best[$id]['score'] || ($score === $best[$id]['score'] && $primary === '1')) {
                $best[$id] = ['score' => $score, 'matched' => $display, 'primary' => $primary === '1'];
            }
        }

        uasort($best, fn ($a, $b) => $b['score'] <=> $a['score']);
        $total = count($best);
        $out = [];
        foreach (array_slice($best, 0, $limit, true) as $id => $m) {
            if ($e = self::entity($id)) {
                $out[] = self::present($e) + ['score' => (int) floor($m['score'] * 100), 'matched' => $m['matched'], 'matched_alias' => ! $m['primary']];
            }
        }

        return ['total' => $total, 'results' => $out];
    }

    private static function score(array $q, array $n, array $tokenSim, string $qCompact = '', string $nCompact = ''): float
    {
        $sum = 0;
        $len = 0;
        $used = [];
        foreach ($q as $qt) {
            $b = 0.0;
            $bi = null;
            foreach ($n as $i => $nt) {
                if (isset($used[$i])) {
                    continue;
                }
                $s = $qt === $nt ? 1.0 : ($tokenSim[$qt][$nt] ?? (strlen($qt) === 1 && $nt[0] === $qt ? 0.9 : 0.0));
                if ($s > $b) {
                    $b = $s;
                    $bi = $i;
                }
            }
            if ($bi !== null && $b >= 0.8) {
                $used[$bi] = true;
            } else {
                $b = 0.0;
            }
            $w = max(2, strlen($qt));
            $sum += $b * $w;
            $len += $w;
        }
        $qScore = $len ? $sum / $len : 0;

        // Cuánto del nombre de la lista quedó cubierto por la búsqueda.
        $cov = 0;
        $tot = 0;
        foreach ($n as $i => $nt) {
            $w = max(2, strlen($nt));
            $tot += $w;
            if (isset($used[$i])) {
                $cov += $w;
            }
        }
        $nScore = $tot ? $cov / $tot : 0;

        $token = 0.9 * $qScore + 0.1 * $nScore;
        // Comparación del nombre completo sin espacios (une «al qaida», «al-qa'ida» y «alqaida»).
        if ($qCompact !== '' && $nCompact !== '' && abs(strlen($qCompact) - strlen($nCompact)) <= max(3, (int) (strlen($qCompact) * 0.25))) {
            $full = $qCompact === $nCompact ? 1.0 : self::jaroWinkler($qCompact, $nCompact);
            if ($full >= 0.94) {
                $token = max($token, $full);
            }
        }

        return $token;
    }

    public static function jaroWinkler(string $a, string $b): float
    {
        $la = strlen($a);
        $lb = strlen($b);
        if ($la === 0 || $lb === 0) {
            return 0.0;
        }
        $range = max(0, intdiv(max($la, $lb), 2) - 1);
        $ma = array_fill(0, $la, false);
        $mb = array_fill(0, $lb, false);
        $m = 0;
        for ($i = 0; $i < $la; $i++) {
            $lo = max(0, $i - $range);
            $hi = min($i + $range + 1, $lb);
            for ($j = $lo; $j < $hi; $j++) {
                if (! $mb[$j] && $a[$i] === $b[$j]) {
                    $ma[$i] = $mb[$j] = true;
                    $m++;
                    break;
                }
            }
        }
        if ($m === 0) {
            return 0.0;
        }
        $t = 0;
        $k = 0;
        for ($i = 0; $i < $la; $i++) {
            if ($ma[$i]) {
                while (! $mb[$k]) {
                    $k++;
                }
                if ($a[$i] !== $b[$k]) {
                    $t++;
                }
                $k++;
            }
        }
        $jaro = ($m / $la + $m / $lb + ($m - $t / 2) / $m) / 3;
        $p = 0;
        $max = min(4, $la, $lb);
        while ($p < $max && $a[$p] === $b[$p]) {
            $p++;
        }

        return $jaro + $p * 0.1 * (1 - $jaro);
    }

    // ── Presentación ────────────────────────────────────────────────────────

    public static function present(array $e): array
    {
        $facts = [];
        foreach (array_filter(array_map('trim', explode(';', $e['r']))) as $part) {
            $facts[] = $part;
        }

        return [
            'id' => $e['id'],
            'name' => $e['n'],
            'type' => $e['t'],
            'type_label' => ['i' => 'Persona', 'e' => 'Entidad', 'v' => 'Embarcación', 'a' => 'Aeronave'][$e['t']],
            'list' => $e['l'],
            'list_label' => $e['l'] === 'S' ? 'Lista SDN' : 'Lista consolidada (no SDN)',
            'programs' => array_map(fn ($p) => ['code' => $p, 'label' => OfacPrograms::label($p)], $e['p']),
            'aliases' => array_map(fn ($a) => ['kind' => $a[0], 'name' => $a[1]], $e['al']),
            'addresses' => $e['ad'],
            'countries' => $e['co'],
            'facts' => $facts,
            'title' => $e['ti'],
            'vessel' => array_filter(['Distintivo de llamada' => $e['cs'], 'Tipo' => $e['vt'], 'Bandera' => $e['vf'], 'Propietario' => $e['vo']]),
            'ofac_url' => 'https://sanctionssearch.ofac.treas.gov/Details.aspx?id='.$e['id'],
        ];
    }
}
