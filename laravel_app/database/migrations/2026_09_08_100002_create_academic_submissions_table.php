<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_activity_id')->constrained('academic_activities')->cascadeOnDelete();
            $table->enum('mode', ['individual', 'grupal']);
            $table->string('group_code')->nullable()->unique();
            $table->enum('status', ['pendiente', 'aprobado', 'no_aprobado'])->default('pendiente');
            $table->json('answers')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_submissions');
    }
};
