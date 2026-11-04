<?php

namespace App\Http\Controllers;

use App\Support\ServiceCatalog;

class ServiceController extends Controller
{
    public function show(string $slug)
    {
        $service = ServiceCatalog::find($slug);
        abort_unless($service, 404);

        $others = collect(ServiceCatalog::all())->except($slug)->take(3);

        return view('site.services.'.$slug, compact('service', 'others'));
    }
}
