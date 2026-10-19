<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Optional bonus upload for an activity: when upload_bonus_points is set, the
     * interactive page shows a last, non-graded "sube tu archivo" card (PDF or Word) and,
     * if the student attaches one, the activity's score gets those extra points on top of
     * the auto-graded total. Both columns stay null for every existing activity, so this
     * is purely additive. The uploaded file itself lives on the submission.
     */
    public function up(): void
    {
        Schema::table('academic_activities', function (Blueprint $table) {
            $table->text('upload_prompt')->nullable()->after('pass_percent');
            $table->unsignedTinyInteger('upload_bonus_points')->nullable()->after('upload_prompt');
        });

        Schema::table('academic_submissions', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('answers');
            $table->string('file_name')->nullable()->after('file_path');
        });
    }

    public function down(): void
    {
        Schema::table('academic_activities', function (Blueprint $table) {
            $table->dropColumn(['upload_prompt', 'upload_bonus_points']);
        });

        Schema::table('academic_submissions', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'file_name']);
        });
    }
};
