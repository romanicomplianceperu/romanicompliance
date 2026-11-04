<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Solicitudes que llegan desde las herramientas de cada servicio (diagnóstico de riesgo,
     * evaluación de congelamiento, propuesta PSAV, etc.) y desde el formulario de contacto.
     * El equipo las gestiona en el panel admin: estado, notas, monto cotizado y seguimiento.
     */
    public function up(): void
    {
        Schema::create('service_leads', function (Blueprint $table) {
            $table->id();
            $table->string('service_slug', 60)->index();
            $table->string('service_name');
            $table->string('name', 120);
            $table->string('organization', 160)->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 30)->nullable();
            $table->text('summary');
            $table->json('data')->nullable();
            $table->unsignedTinyInteger('score')->nullable();
            $table->string('level', 60)->nullable();
            $table->string('status', 20)->default('nuevo')->index();
            $table->text('admin_notes')->nullable();
            $table->decimal('quote_amount', 12, 2)->nullable();
            $table->string('quote_currency', 3)->default('PEN');
            $table->date('follow_up_at')->nullable();
            $table->timestamp('contacted_at')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_leads');
    }
};
