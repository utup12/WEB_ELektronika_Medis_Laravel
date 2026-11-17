<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('module');
            $table->string('file_path');
            $table->string('original_name');
            $table->string('status')->default('submitted');
            $table->decimal('score', 5, 2)->nullable();
            $table->text('feedback')->nullable();
            $table->timestamps();
        });

        Schema::create('quiz_attempts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('module')->default('Kesiapan Praktikum');
            $table->unsignedTinyInteger('score');
            $table->unsignedTinyInteger('total');
            $table->json('answers');
            $table->timestamp('submitted_at');
            $table->timestamps();
        });

        Schema::create('module_progress', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('module');
            $table->string('activity');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'module', 'activity']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('module_progress');
        Schema::dropIfExists('quiz_attempts');
        Schema::dropIfExists('reports');
    }
};
