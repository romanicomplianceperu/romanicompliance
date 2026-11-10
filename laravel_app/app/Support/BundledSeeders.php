<?php

namespace App\Support;

use App\Models\AcademicActivity;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

/**
 * Actividades académicas incluidas en el código que se publican solas la primera vez que
 * se visita el sitio tras un despliegue (sin correr comandos en el servidor).
 * Cada seeder corre UNA sola vez: si la actividad ya existe no se toca, para no pisar los
 * cambios hechos después desde /soyflojo o el panel admin (fecha, código, estado).
 * Para agregar una: sumar [slug => clase del seeder] a SEEDERS y cambiar VERSION.
 */
class BundledSeeders
{
    private const VERSION = 'v1';

    private const SEEDERS = [
        \Database\Seeders\AcademicoProcesalSemana8Seeder::SLUG => \Database\Seeders\AcademicoProcesalSemana8Seeder::class,
    ];

    public static function ensure(): void
    {
        $key = 'bundled_seeders_'.self::VERSION;
        try {
            if (Cache::get($key)) {
                return;
            }
        } catch (\Throwable $e) {
            // Si la caché falla, se sigue: la consulta de abajo es liviana.
        }
        try {
            if (! Schema::hasTable('academic_activities')) {
                return;
            }
            foreach (self::SEEDERS as $slug => $class) {
                if (! AcademicActivity::where('slug', $slug)->exists()) {
                    app($class)->run();
                }
            }
            rescue(fn () => Cache::forever($key, true), null, false);
        } catch (\Throwable $e) {
            Log::warning('No se pudo publicar una actividad incluida: '.$e->getMessage());
            rescue(fn () => Cache::put($key, true, now()->addMinutes(10)), null, false);
        }
    }
}
