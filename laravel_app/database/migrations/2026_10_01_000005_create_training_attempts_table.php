<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained('trainings')->cascadeOnDelete();
            $table->string('full_name');
            $table->enum('position', ['juez', 'fiscal', 'otro']);
            $table->string('position_other')->nullable();
            $table->timestamp('started_at');
            $table->timestamp('finished_at')->nullable();
            $table->unsignedInteger('time_limit_seconds');
            $table->unsignedInteger('total_questions')->default(0);
            $table->unsignedInteger('correct_count')->nullable();
            $table->decimal('score_percent', 5, 2)->nullable();
            $table->json('answers')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_attempts');
    }
};
