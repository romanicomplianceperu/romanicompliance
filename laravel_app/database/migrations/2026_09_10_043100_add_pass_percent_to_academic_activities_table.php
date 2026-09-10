<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Optional pass threshold (0-100) for an activity's auto-graded exercises. When set,
     * the celebratory confetti on submit only fires if the student's score meets it —
     * when left null (the default, and the value every existing activity keeps), confetti
     * keeps firing unconditionally on submit exactly as it always has, so this is purely
     * additive and changes nothing for activities that don't opt in.
     */
    public function up(): void
    {
        Schema::table('academic_activities', function (Blueprint $table) {
            $table->unsignedTinyInteger('pass_percent')->nullable()->after('due_at');
        });
    }

    public function down(): void
    {
        Schema::table('academic_activities', function (Blueprint $table) {
            $table->dropColumn('pass_percent');
        });
    }
};
