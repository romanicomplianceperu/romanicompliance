<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_course_id')->constrained('academic_courses')->cascadeOnDelete();
            $table->string('slug');
            $table->unsignedInteger('week_number');
            $table->enum('type', ['participacion', 'tarea', 'cuestionario'])->default('participacion');
            $table->string('title');
            $table->string('case_title')->nullable();
            $table->string('unit')->nullable();
            $table->string('modality')->nullable();
            $table->string('group_size')->nullable();
            $table->longText('case_body')->nullable();
            $table->string('case_document_path')->nullable();
            $table->enum('status', ['disponible', 'proximamente', 'cerrada'])->default('proximamente');
            $table->timestamps();

            $table->unique(['academic_course_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_activities');
    }
};
