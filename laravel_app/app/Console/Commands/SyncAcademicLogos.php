<?php

namespace App\Console\Commands;

use App\Models\AcademicUniversity;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

/**
 * The three university logos (UNP, UTP, UPRIT) are version-controlled as base64 blobs
 * under database/seeders/data/ and normally get written to the "public" disk by
 * AcademicoSeeder. On production the files went missing from public_html/storage at
 * some point (found 404-ing on a fresh, uncached request — a browser or CDN cache had
 * been quietly hiding it), so this command re-materializes just the three logo files
 * and refreshes their logo_url, without touching AcademicoSeeder's course/activity/
 * question rows — safe to run anytime, as often as needed, with zero risk to existing
 * student submissions.
 */
class SyncAcademicLogos extends Command
{
    protected $signature = 'academico:sync-logos';

    protected $description = 'Vuelve a escribir los logos de las universidades (UNP, UTP, UPRIT) desde los assets versionados en git y actualiza su logo_url. No toca cursos, actividades ni envíos de alumnos.';

    public function handle(): int
    {
        $logos = [
            'unp' => ['file' => 'unp-logo.png.b64', 'ext' => 'png'],
            'utp' => ['file' => 'utp-logo.jpg.b64', 'ext' => 'jpg'],
            'uprit' => ['file' => 'uprit-logo.png.b64', 'ext' => 'png'],
        ];

        foreach ($logos as $slug => $info) {
            $source = database_path('seeders/data/'.$info['file']);

            if (! file_exists($source)) {
                $this->warn("Asset no encontrado: {$info['file']} — se omite {$slug}.");

                continue;
            }

            $storagePath = 'universities/'.$slug.'.'.$info['ext'];
            Storage::disk('public')->put($storagePath, base64_decode(file_get_contents($source)));
            $url = asset('storage/'.$storagePath);

            $updated = AcademicUniversity::where('slug', $slug)->update(['logo_url' => $url]);

            $this->info("{$slug}: escrito {$storagePath} -> {$url}".
                ($updated ? '' : ' (aviso: no existe una universidad con slug "'.$slug.'" en la base de datos)'));
        }

        $this->info('Listo. Si alguna sigue sin cargar, corre también: php artisan storage:link y php artisan storage:sync-public-html');

        return self::SUCCESS;
    }
}
