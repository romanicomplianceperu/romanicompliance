<?php

namespace App\Http\Controllers;

use App\Support\Ofac\OfacList;
use App\Support\Ofac\OfacPrograms;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/** romanicompliance.com/buscador — búsqueda en las listas de sanciones de OFAC. */
class OfacSearchController extends Controller
{
    public function index(Request $request)
    {
        OfacList::ensure();
        OfacList::refreshInBackgroundIfStale();
        $idx = OfacList::index();

        $programs = collect($idx['programs'] ?? [])->map(fn ($n, $code) => ['code' => $code, 'label' => OfacPrograms::label($code), 'n' => $n])
            ->sortBy('label', SORT_NATURAL | SORT_FLAG_CASE)->values();

        return view('buscador.index', [
            'meta' => $idx['meta'] ?? [],
            'programs' => $programs,
            'countries' => $idx['countries'] ?? [],
            'initial' => (string) $request->query('q', ''),
        ]);
    }

    public function search(Request $request)
    {
        $f = $this->filters($request);
        $q = trim((string) $request->query('q', ''));
        if (mb_strlen($q) < 2) {
            return response()->json(['total' => 0, 'results' => []]);
        }
        OfacList::ensure();

        return response()->json(OfacList::search($q, $f + ['limit' => 40]));
    }

    /** Autocompletado mientras se escribe. */
    public function suggest(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        if (mb_strlen($q) < 2) {
            return response()->json([]);
        }
        OfacList::ensure();

        return response()->json(OfacList::suggest(mb_substr($q, 0, 80)));
    }

    /** Ficha en PDF de un resultado: todos sus datos y la búsqueda que lo encontró. */
    public function record(Request $request, int $id)
    {
        OfacList::ensure();
        $e = OfacList::entity($id);
        abort_unless($e, 404);
        $r = OfacList::present($e);
        $q = mb_substr(trim((string) $request->query('q', '')), 0, 120);
        $score = $request->filled('score') ? max(0, min(100, (int) $request->query('score'))) : null;
        $matched = mb_substr(trim((string) $request->query('via', '')), 0, 200);
        $meta = OfacList::meta();
        $now = now()->timezone('America/Lima');
        $code = strtoupper(substr(hash('sha256', $id.$q.$now->toIso8601String()), 0, 10));
        $logo = 'data:image/png;base64,'.base64_encode((string) @file_get_contents(public_path('images/logos.png')));

        $pdf = Pdf::loadView('buscador.ficha', compact('r', 'q', 'score', 'matched', 'meta', 'now', 'code', 'logo'))
            ->setPaper('a4')->setOption('isFontSubsettingEnabled', true);

        return $pdf->download('ficha-ofac-'.$id.'-'.Str::slug(Str::limit($r['name'], 50, '')).'.pdf');
    }

    /** Varios nombres a la vez (uno por línea): el mejor resultado de cada uno. */
    public function batch(Request $request)
    {
        $data = $request->validate(['names' => ['required', 'string', 'max:6000']]);
        $f = $this->filters($request);
        OfacList::ensure();
        $names = collect(preg_split('/\r?\n/', $data['names']))->map(fn ($n) => trim($n))->filter(fn ($n) => mb_strlen($n) >= 2)->unique()->take(50)->values();

        $rows = $names->map(function ($name) use ($f) {
            $r = OfacList::search($name, $f + ['limit' => 3]);

            return ['query' => $name, 'total' => $r['total'] ?? 0, 'results' => $r['results'] ?? []];
        });

        return response()->json(['rows' => $rows]);
    }

    /** Constancia en PDF de la búsqueda (fecha, versión de la lista, filtros y resultados). */
    public function certificate(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        abort_if(mb_strlen($q) < 2, 422);
        $f = $this->filters($request);
        OfacList::ensure();
        $res = OfacList::search($q, $f + ['limit' => 25]);
        $meta = OfacList::meta();
        $now = now()->timezone('America/Lima');
        $ref = mb_substr(trim((string) $request->query('ref', '')), 0, 120);
        $code = strtoupper(substr(hash('sha256', $q.json_encode($f).$now->toIso8601String().($meta['built_at'] ?? '')), 0, 10));
        $logo = 'data:image/png;base64,'.base64_encode((string) @file_get_contents(public_path('images/logos.png')));

        $pdf = Pdf::loadView('buscador.constancia', compact('q', 'f', 'res', 'meta', 'now', 'ref', 'code', 'logo'))
            ->setPaper('a4')->setOption('isFontSubsettingEnabled', true);

        return $pdf->download('constancia-ofac-'.Str::slug(Str::limit($q, 40, '')).'-'.$now->format('Ymd-Hi').'.pdf');
    }

    private function filters(Request $request): array
    {
        return [
            'type' => in_array($request->query('tipo'), ['i', 'e', 'v', 'a'], true) ? $request->query('tipo') : null,
            'list' => in_array($request->query('lista'), ['S', 'C'], true) ? $request->query('lista') : null,
            'program' => $request->filled('programa') ? Str::limit((string) $request->query('programa'), 60, '') : null,
            'country' => $request->filled('pais') ? Str::limit((string) $request->query('pais'), 80, '') : null,
            'min' => (int) $request->query('min', 85),
        ];
    }
}
