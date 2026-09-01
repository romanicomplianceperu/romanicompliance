<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_id')->constrained('academic_universities')->cascadeOnDelete();
            $table->string('slug');
            $table->string('name');
            $table->string('subtitle')->nullable();
            $table->string('faculty')->nullable();
            $table->string('period')->nullable();
            $table->unsignedInteger('total_weeks')->default(16);
            $table->enum('status', ['active', 'soon'])->default('soon');
            $table->timestamps();

            $table->unique(['university_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_courses');
    }
};
