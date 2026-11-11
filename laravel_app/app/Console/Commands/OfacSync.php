<?php

namespace App\Console\Commands;

use App\Support\Ofac\OfacList;
use Illuminate\Console\Command;

class OfacSync extends Command
{
    protected $signature = 'ofac:sync';

    protected $description = 'Descarga las listas de sanciones de OFAC y actualiza el índice del buscador';

    public function handle(): int
    {
        $r = OfacList::sync(allowSnapshot: true);
        if (! $r['ok']) {
            $this->error('No se pudo actualizar: '.($r['error'] ?? ''));

            return self::FAILURE;
        }
        $this->info("Listas OFAC actualizadas ({$r['source']}): {$r['entities']} registros, {$r['names']} nombres.");

        return self::SUCCESS;
    }
}
