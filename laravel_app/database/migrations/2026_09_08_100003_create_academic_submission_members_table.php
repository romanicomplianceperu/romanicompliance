<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_submission_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_submission_id')->constrained('academic_submissions')->cascadeOnDelete();
            $table->string('full_name');
            $table->string('email');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_submission_members');
    }
};
