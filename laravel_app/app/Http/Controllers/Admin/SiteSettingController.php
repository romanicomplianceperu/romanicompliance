<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    /**
     * Campos editables del sitio, agrupados por sección.
     * Agregar una nueva entrada aquí es suficiente para que aparezca en el
     * panel; no hace falta tocar el controlador ni la migración.
     */
    public const FIELDS = [
        'Inicio — Portada' => [
            'home_hero_eyebrow' => ['label' => 'Texto pequeño sobre el título', 'type' => 'text'],
            'home_hero_title' => ['label' => 'Título principal', 'type' => 'text'],
            'home_hero_subtitle' => ['label' => 'Subtítulo', 'type' => 'textarea'],
        ],
        'Inicio — Misión y visión' => [
            'home_mission' => ['label' => 'Misión', 'type' => 'textarea'],
            'home_vision' => ['label' => 'Visión', 'type' => 'textarea'],
        ],
        'Inicio — Sección de cursos' => [
            'home_courses_title' => ['label' => 'Título de la sección', 'type' => 'text'],
            'home_courses_subtitle' => ['label' => 'Subtítulo de la sección', 'type' => 'textarea'],
        ],
        'General' => [
            'site_meta_description' => ['label' => 'Descripción para buscadores (SEO)', 'type' => 'textarea'],
        ],
    ];

    public function index()
    {
        $values = SiteSetting::pluck('value', 'key');

        return view('admin.settings.index', ['groups' => self::FIELDS, 'values' => $values]);
    }

    public function update(Request $request)
    {
        $allKeys = collect(self::FIELDS)->flatMap(fn ($fields) => array_keys($fields))->all();

        $data = $request->validate(
            collect($allKeys)->mapWithKeys(fn ($key) => [$key => ['nullable', 'string']])->all()
        );

        foreach ($allKeys as $key) {
            SiteSetting::set($key, $data[$key] ?? null);
        }

        return back()->with('success', 'Cambios guardados correctamente.');
    }
}
