<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Postulaciones al programa de prácticas de Romani Compliance, recibidas desde la
     * convocatoria pública en /academico/convocatoria/postular. Todo lo que el aspirante
     * marca en el "test" de inscripción se guarda tal cual, sin normalizar en columnas
     * separadas, porque el conjunto de preguntas puede evolucionar con el tiempo.
     */
    public function up(): void
    {
        Schema::create('internship_applications', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone');
            $table->string('email');
            $table->string('interest_area');
            $table->string('occupation_status');
            $table->json('schedule_availability');
            $table->string('weekly_hours');
            $table->json('skills');
            $table->string('academic_cycle');
            $table->json('specialized_answers');
            $table->text('motivation')->nullable();
            $table->string('status')->default('pendiente');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internship_applications');
    }
};
