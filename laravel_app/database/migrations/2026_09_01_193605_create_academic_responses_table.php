<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_activity_question_id')->constrained('academic_activity_questions')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('body')->nullable();
            $table->enum('status', ['borrador', 'enviada', 'calificada'])->default('borrador');
            $table->decimal('grade', 4, 2)->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->unique(['academic_activity_question_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_responses');
    }
};
