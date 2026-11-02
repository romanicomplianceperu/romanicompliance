<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * When true, the activity is not listed to students at all (and its direct URL is
     * refused). Defaults to false, so every existing activity stays listed as before.
     */
    public function up(): void
    {
        Schema::table('academic_activities', function (Blueprint $table) {
            $table->boolean('is_hidden')->default(false)->after('upload_required');
        });
    }

    public function down(): void
    {
        Schema::table('academic_activities', function (Blueprint $table) {
            $table->dropColumn('is_hidden');
        });
    }
};
