<?php

namespace App\Http\Controllers;

use App\Support\ServiceCatalog;
use App\Support\TrainingCatalog;

/** Páginas públicas de capacitaciones (formato nuevo): /capacitaciones/{slug}. */
class TrainingController extends Controller
{
    public function show(string $slug)
    {
        $t = TrainingCatalog::find($slug);
        abort_unless($t, 404);

        return view('capacitaciones.show', [
            't' => $t,
            'slug' => $slug,
            'leadUrl' => route('services.leads.store', TrainingCatalog::leadSlug($slug)),
            'embed' => TrainingCatalog::embed($t['video'] ?? null),
            'wa' => ServiceCatalog::whatsapp($t['whatsapp']),
        ]);
    }
}
