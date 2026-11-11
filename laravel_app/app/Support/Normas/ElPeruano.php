<?php

namespace App\Support\Normas;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Throwable;

/**
 * Consulta en vivo el buscador público del Diario Oficial El Peruano
 * (busquedas.elperuano.pe) y devuelve los dispositivos encontrados, con
 * enlace a la norma original. Solo lee la primera página de resultados.
 */
class ElPeruano
{
    public const BASE = 'https://busquedas.elperuano.pe';

    /** Bytes que bastan para leer la primera página de resultados (las tarjetas van al inicio del HTML). */
    private const READ_BYTES = 260000;

    public static function searchUrl(string $q): string
    {
        return self::BASE.'/?'.http_build_query(['query' => self::query($q), 'start' => 0, 'ci' => 'all']);
    }

    /** @return array{results: array<int, array>, total: int|null, url: string, error?: bool} */
    public static function search(string $q): array
    {
        $q = trim(preg_replace('/\s+/u', ' ', $q));
        $url = self::searchUrl($q);

        $key = 'elperuano:'.md5(Str::lower($q));
        if (is_array($hit = Cache::get($key))) {
            return $hit;
        }
        $html = self::fetch($url);
        if ($html === null) {
            $res = ['results' => [], 'total' => null, 'url' => $url, 'error' => true];
            Cache::put($key, $res, now()->addMinutes(10));

            return $res;
        }
        $total = preg_match('/totalHits\\\\?",(\d+)/', $html, $m) ? (int) $m[1] : null;
        $res = ['results' => self::rank(self::parse($html), $q), 'total' => $total, 'url' => $url];
        Cache::put($key, $res, now()->addHours(6));

        return $res;
    }

    /**
     * Número de norma contenido en la búsqueda («2660-2015», «020-2017-JUS», «Ley 30424», «D. Leg. 1106»).
     * El buscador oficial ordena por fecha y cuenta coincidencias en el cuerpo del texto, así que solo
     * da resultados útiles cuando se le pide un número exacto.
     */
    public static function number(string $q): ?string
    {
        if (preg_match('/\b\d{1,6}-\d{4}(?:-[A-Z]{2,8}(?:\/[A-Z0-9.]+)?)?\b/i', $q, $m)) {
            return strtoupper($m[0]);
        }
        if (preg_match('/\b(?:ley|decreto\s+legislativo|d\.?\s*leg(?:islativo)?\.?|dl)\s*(?:n\.?\s*[°º]?\s*)?(\d{3,5})\b/iu', $q, $m)) {
            return $m[1];
        }

        return null;
    }

    private static function query(string $q): string
    {
        return ($n = self::number($q)) ? '"'.$n.'"' : $q;
    }

    private static function fetch(string $url): ?string
    {
        if (! function_exists('curl_init')) {
            return null;
        }
        try {
            $buf = '';
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 3,
                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_TIMEOUT => 8,
                CURLOPT_ENCODING => '',
                CURLOPT_HTTPHEADER => ['Accept: text/html', 'Accept-Language: es-PE,es;q=0.9'],
                CURLOPT_USERAGENT => 'RomaniCompliance-BuscadorNormas/1.0 (+https://romanicompliance.com/herramientas/normas-laft)',
                // Se corta la descarga en cuanto llega la primera página de resultados.
                CURLOPT_WRITEFUNCTION => function ($ch, $data) use (&$buf) {
                    $buf .= $data;

                    return strlen($buf) >= self::READ_BYTES ? 0 : strlen($data);
                },
            ]);
            if ($ca = getenv('CURL_CA_BUNDLE') ?: getenv('SSL_CERT_FILE')) {
                curl_setopt($ch, CURLOPT_CAINFO, $ca);
            }
            curl_exec($ch);
            $code = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
            curl_close($ch);

            return $code === 200 && $buf !== '' ? $buf : null;
        } catch (Throwable) {
            return null;
        }
    }

    /** Extrae las tarjetas de resultado del HTML que El Peruano renderiza en el servidor. */
    public static function parse(string $html): array
    {
        $out = [];
        $re = '~text-sm font-semibold text-primary">([^<]+)</p>.*?href="(/dispositivo/[A-Z]{2}/[0-9]+-[0-9]+)".*?'
            .'<p class="text-xs text-muted-foreground">([^<]*)</p><p class="text-xs font-medium text-muted-foreground">([^<]*)</p>'
            .'.*?line-clamp-3"[^>]*>([^<]+)</a>.*?<span>[^<]*</span><span>([^<]+)</span>~s';
        if (! preg_match_all($re, $html, $mm, PREG_SET_ORDER)) {
            return [];
        }
        foreach ($mm as $m) {
            $dec = fn ($s) => trim(html_entity_decode($s, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            $num = preg_replace('/^N[°º]\s*/u', '', $dec($m[4]));
            $num = preg_replace('/^SBS\s*N[°º]\s*/u', '', $num);
            $fecha = $dec($m[6]);
            $iso = preg_match('/(\d{2})\.(\d{2})\.(\d{4})/', $fecha, $d) ? "$d[3]-$d[2]-$d[1]" : null;
            $out[$m[2]] = [
                'entidad' => preg_replace_callback('/\\b(De|Del|La|Las|Los|Y|E|En|Para|Por|A)\\b/u', fn ($w) => Str::lower($w[0]), Str::title(Str::lower($dec($m[1])))),
                'tipo' => Str::ucfirst(Str::lower($dec($m[3]))),
                'numero' => $num,
                'titulo' => $dec($m[5]),
                'fecha' => $fecha,
                'fecha_iso' => $iso,
                'url' => self::BASE.$m[2],
            ];
        }

        return array_values($out);
    }

    /** Ordena por pertinencia: el buscador oficial ordena por fecha y también cuenta coincidencias en el cuerpo. */
    private static function rank(array $items, string $q): array
    {
        $norm = fn ($s) => Str::lower(Str::ascii($s));
        $nq = $norm($q);
        $num = self::number($q);
        $numKey = $num ? ltrim($norm($num), '0') : null;
        $wantSbs = (bool) preg_match('/\bsbs\b|superintendencia de banca/', $nq);
        $wantLey = (bool) preg_match('/\bley\b/', $nq);
        $wantDl = (bool) preg_match('/decreto legislativo|d\.?\s*leg|\bdl\b/', $nq);

        $items = collect($items)->map(function ($it) use ($norm, $numKey, $wantSbs, $wantLey, $wantDl) {
            $title = $norm($it['titulo']);
            $n = ltrim($norm($it['numero']), '0');
            $tipo = $norm($it['tipo']);
            $isSbs = str_contains($norm($it['entidad']), 'superintendencia de banca');
            $s = 0;
            if ($numKey && (str_starts_with($n, $numKey) || preg_match('/(^|[^0-9])0*'.preg_quote($numKey, '/').'($|[^0-9])/', $n))) {
                $s += 100;   // es la norma buscada
            } elseif ($numKey && str_contains($title, $numKey)) {
                $s += 40;    // la modifica, la reglamenta o la cita en su sumilla
            }
            if ($wantSbs && $isSbs) { $s += 15; }
            if ($wantSbs && ! $isSbs) { $s -= 60; }
            if ($wantLey && str_starts_with($tipo, 'ley')) { $s += 15; }
            if ($wantDl && str_contains($tipo, 'decreto legislativo')) { $s += 15; }
            if (str_contains($tipo, 'fe de errata')) { $s -= 20; }
            if (preg_match('/lavado|terroris|\buif\b|financiamiento|sospechos|congelamiento|activos virtuales|cumplimiento/', $title)) { $s += 8; }
            $it['score'] = $s;

            return $it;
        });

        return $items->filter(fn ($i) => $i['score'] >= 50)
            ->unique(fn ($i) => $i['numero'].'|'.$i['titulo'])
            ->sortBy([['score', 'desc'], ['fecha_iso', 'desc']])
            ->take(8)
            ->map(fn ($i) => collect($i)->except('score')->all())
            ->values()
            ->all();
    }
}
