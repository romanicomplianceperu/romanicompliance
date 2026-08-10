<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SyncPublicHtmlStorage extends Command
{
    protected $signature = 'storage:sync-public-html';

    protected $description = 'Copia a public_html/storage los archivos que quedaron atrapados en storage/app/public antes de la corrección del disco "public" (ejecutar una sola vez tras el deploy)';

    public function handle(): int
    {
        $source = storage_path('app/public');
        $target = base_path('../public_html/storage');

        if (! is_dir($target)) {
            $this->error("No se encontró {$target}. Este comando solo aplica al layout de Hostinger (public_html hermano de este proyecto).");

            return self::FAILURE;
        }

        if (! is_dir($source)) {
            $this->info('No hay nada que sincronizar: storage/app/public no existe.');

            return self::SUCCESS;
        }

        $copied = 0;

        foreach (File::allFiles($source) as $file) {
            $relative = $file->getRelativePathname();
            $destination = $target.DIRECTORY_SEPARATOR.$relative;

            if (File::exists($destination)) {
                continue;
            }

            File::ensureDirectoryExists(dirname($destination));
            File::copy($file->getPathname(), $destination);
            $this->line("Copiado: {$relative}");
            $copied++;
        }

        $this->info("Listo. {$copied} archivo(s) sincronizado(s) hacia public_html/storage.");

        return self::SUCCESS;
    }
}
