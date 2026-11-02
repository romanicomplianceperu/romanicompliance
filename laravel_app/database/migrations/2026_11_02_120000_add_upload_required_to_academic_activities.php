<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * When true, the activity cannot be sent (action "enviar") without the student's work
     * file (PDF or Word) attached. Defaults to false, so every existing activity keeps
     * working exactly as before.
     */
    public function up(): void
    {
        Schema::table('academic_activities', function (Blueprint $table) {
            $table->boolean('upload_required')->default(false)->after('upload_bonus_points');
        });
    }

    public function down(): void
    {
        Schema::table('academic_activities', function (Blueprint $table) {
            $table->dropColumn('upload_required');
        });
    }
};
