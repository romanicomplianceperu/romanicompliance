<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Support\Normas\ElPeruano;
use App\Support\ServiceCatalog;
use Illuminate\Http\Request;

/** Sección «Herramientas y recursos» y mapa del sitio para buscadores. */
class ToolsController extends Controller
{
    public function index()
    {
        return view('herramientas.index', ['normasCount' => count(self::catalog()['normas'] ?? [])]);
    }

    public function normas()
    {
        $data = self::catalog();
        $normas = collect($data['normas'] ?? [])->sortByDesc(fn ($n) => $n['fecha_iso'] ?? (string) $n['anio'])->values();

        return view('herramientas.normas', [
            'normas' => $normas,
            'updated' => $data['updated_at'] ?? null,
            'initial' => mb_substr(trim((string) request()->query('q', '')), 0, 120),
        ]);
    }

    /** Búsqueda de un número de norma en el Diario Oficial El Peruano (complementa al catálogo). */
    public function normasElPeruano(Request $request)
    {
        $q = mb_substr(trim((string) $request->query('q', '')), 0, 120);
        if (mb_strlen($q) < 3 || ! ElPeruano::number($q)) {
            return response()->json(['results' => [], 'url' => ElPeruano::searchUrl($q)]);
        }

        return response()->json(ElPeruano::search($q))->header('Cache-Control', 'public, max-age=1800');
    }

    public function sitemap()
    {
        $urls = [
            [route('home'), '1.0', 'weekly'],
            [route('buscador'), '0.9', 'daily'],
            [route('herramientas'), '0.8', 'monthly'],
            [route('herramientas.normas'), '0.8', 'monthly'],
            [route('capacitaciones'), '0.7', 'monthly'],
            [route('equipo'), '0.6', 'monthly'],
            [route('blog.index'), '0.7', 'weekly'],
            [route('courses.catalog'), '0.6', 'weekly'],
        ];
        foreach (array_keys(ServiceCatalog::all()) as $slug) {
            $urls[] = [route('services.show', $slug), '0.8', 'monthly'];
        }
        $articles = rescue(fn () => Article::published()->get(['slug', 'updated_at']), collect(), false);
        foreach ($articles as $a) {
            $urls[] = [route('blog.show', $a), '0.6', 'monthly', optional($a->updated_at)->toAtomString()];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n".'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
        foreach ($urls as $u) {
            $xml .= '  <url><loc>'.e($u[0]).'</loc>'.(! empty($u[3]) ? '<lastmod>'.$u[3].'</lastmod>' : '').'<changefreq>'.$u[2].'</changefreq><priority>'.$u[1].'</priority></url>'."\n";
        }
        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    public static function catalog(): array
    {
        return json_decode((string) @file_get_contents(database_path('content/normas-laft.json')), true) ?: [];
    }
}
