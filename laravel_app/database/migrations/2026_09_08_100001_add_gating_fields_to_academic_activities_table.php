<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('academic_activities', function (Blueprint $table) {
            $table->string('access_code')->nullable()->after('status');
            $table->timestamp('due_at')->nullable()->after('access_code');
        });

        Schema::table('academic_courses', function (Blueprint $table) {
            $table->string('code_abbr', 10)->nullable()->after('slug');
        });
    }

    public function down(): void
    {
        Schema::table('academic_activities', function (Blueprint $table) {
            $table->dropColumn(['access_code', 'due_at']);
        });

        Schema::table('academic_courses', function (Blueprint $table) {
            $table->dropColumn('code_abbr');
        });
    }
};
