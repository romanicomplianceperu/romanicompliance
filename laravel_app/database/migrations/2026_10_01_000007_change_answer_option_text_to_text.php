<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE answer_options MODIFY option_text TEXT NOT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE answer_options MODIFY option_text VARCHAR(255) NOT NULL');
    }
};
