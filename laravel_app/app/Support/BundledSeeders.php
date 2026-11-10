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
    private const VERSION = 'v3';

    private const SEEDERS = [
        \Database\Seeders\AcademicoProcesalSemana8Seeder::SLUG => \Database\Seeders\AcademicoProcesalSemana8Seeder::class,
    ];

    /**
     * Corrección puntual de la Semana 8 de Procesal (salió con otro código y otra fecha):
     * código procesal20262 y plazo viernes 20 de noviembre, 8:00 p. m. Solo cambia los
     * valores originales, así no pisa lo que se ajuste luego desde /soyflojo.
     */
    private static function fixProcesalSemana8(): void
    {
        $a = AcademicActivity::where('slug', \Database\Seeders\AcademicoProcesalSemana8Seeder::SLUG)->first();
        if (! $a) {
            return;
        }
        $changes = [];
        if (in_array($a->access_code, ['procesal1311', 'procesal'], true)) {
            $changes['access_code'] = 'procesal20262';
        }
        $oldDue = \Carbon\Carbon::parse('2026-11-13 20:00:00', 'America/Lima');
        if ($a->due_at && $a->due_at->equalTo($oldDue)) {
            $changes['due_at'] = \Carbon\Carbon::parse('2026-11-20 20:00:00', 'America/Lima')->utc();
            if ($a->status === 'cerrada') {
                $changes['status'] = 'disponible';
            }
        }
        if ($a->case_body && str_contains($a->case_body, 'Plazo: viernes 13 de noviembre')) {
            $changes['case_body'] = str_replace('Plazo: viernes 13 de noviembre', 'Plazo: viernes 20 de noviembre', $a->case_body);
        }
        if ($changes) {
            $a->update($changes);
        }
    }

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
            self::fixProcesalSemana8();
            rescue(fn () => Cache::forever($key, true), null, false);
        } catch (\Throwable $e) {
            Log::warning('No se pudo publicar una actividad incluida: '.$e->getMessage());
            rescue(fn () => Cache::put($key, true, now()->addMinutes(10)), null, false);
        }
    }
}
