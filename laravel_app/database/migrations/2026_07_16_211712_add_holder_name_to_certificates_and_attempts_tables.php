<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('exam_attempts', function (Blueprint $table) {
            $table->string('holder_name')->nullable()->after('user_id');
        });

        Schema::table('certificates', function (Blueprint $table) {
            $table->string('holder_name')->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_attempts', function (Blueprint $table) {
            $table->dropColumn('holder_name');
        });

        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn('holder_name');
        });
    }
};
