<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE training_questions MODIFY option_a TEXT NOT NULL');
        DB::statement('ALTER TABLE training_questions MODIFY option_b TEXT NOT NULL');
        DB::statement('ALTER TABLE training_questions MODIFY option_c TEXT NOT NULL');
        DB::statement('ALTER TABLE training_questions MODIFY option_d TEXT NOT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE training_questions MODIFY option_a VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE training_questions MODIFY option_b VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE training_questions MODIFY option_c VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE training_questions MODIFY option_d VARCHAR(255) NOT NULL');
    }
};
