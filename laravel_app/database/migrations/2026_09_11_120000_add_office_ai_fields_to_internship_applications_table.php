<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('internship_applications', function (Blueprint $table) {
            $table->string('office_word_level')->nullable()->after('specialized_answers');
            $table->string('office_excel_level')->nullable()->after('office_word_level');
            $table->json('ai_tools')->nullable()->after('office_excel_level');
            $table->string('ai_tools_paid')->nullable()->after('ai_tools');
        });
    }

    public function down(): void
    {
        Schema::table('internship_applications', function (Blueprint $table) {
            $table->dropColumn(['office_word_level', 'office_excel_level', 'ai_tools', 'ai_tools_paid']);
        });
    }
};
