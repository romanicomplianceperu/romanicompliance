<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // user_id pasa a ser opcional: los certificados manuales de proyectos
        // se emiten para participantes externos sin cuenta (usan holder_name,
        // que ya existía). Se hace por SQL nativo para no depender de
        // doctrine/dbal, que no está instalado en este proyecto.
        DB::statement('ALTER TABLE certificates MODIFY user_id BIGINT UNSIGNED NULL');

        Schema::table('certificates', function (Blueprint $table) {
            $table->foreignId('project_id')->nullable()->after('course_id')->constrained()->nullOnDelete();
            $table->foreignId('project_participant_id')->nullable()->after('project_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropConstrainedForeignId('project_participant_id');
            $table->dropConstrainedForeignId('project_id');
        });

        DB::statement('ALTER TABLE certificates MODIFY user_id BIGINT UNSIGNED NOT NULL');
    }
};
