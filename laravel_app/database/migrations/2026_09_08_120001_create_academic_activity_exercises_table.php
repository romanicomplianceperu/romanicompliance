<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_activity_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_activity_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('order')->default(1);
            $table->string('type', 20); // vf | mcq | matching | ordering
            $table->text('prompt');
            $table->json('payload');
            $table->unsignedTinyInteger('points')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_activity_exercises');
    }
};
