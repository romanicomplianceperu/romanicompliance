<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('internship_applications', function (Blueprint $table) {
            $table->string('ai_tools_other')->nullable()->after('ai_tools_paid');
            $table->string('cv_path')->nullable()->after('ai_tools_other');
        });
    }

    public function down(): void
    {
        Schema::table('internship_applications', function (Blueprint $table) {
            $table->dropColumn(['ai_tools_other', 'cv_path']);
        });
    }
};
