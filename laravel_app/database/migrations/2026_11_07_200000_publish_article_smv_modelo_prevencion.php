<?php

use App\Support\BundledArticles;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;

/**
 * Publica los artículos incluidos en el código (ver App\Support\BundledArticles).
 * El sitio también lo hace solo en la primera visita; esto es por si se corre migrate.
 */
return new class extends Migration
{
    public function up(): void
    {
        Cache::forget('bundled_articles_v1');
        BundledArticles::ensure();
    }

    public function down(): void
    {
        //
    }
};
