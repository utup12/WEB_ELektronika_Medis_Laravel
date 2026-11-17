<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('classrooms', function (Blueprint $table): void { $table->id(); $table->foreignId('lecturer_id')->constrained('users')->cascadeOnDelete(); $table->string('name'); $table->string('code')->unique(); $table->string('semester')->nullable(); $table->timestamps(); });
        Schema::create('classroom_members', function (Blueprint $table): void { $table->id(); $table->foreignId('classroom_id')->constrained()->cascadeOnDelete(); $table->foreignId('user_id')->constrained()->cascadeOnDelete(); $table->string('group_name')->nullable(); $table->timestamps(); $table->unique(['classroom_id','user_id']); });
        Schema::create('attendance_sessions', function (Blueprint $table): void { $table->id(); $table->foreignId('classroom_id')->nullable()->constrained()->nullOnDelete(); $table->string('module'); $table->string('code', 12); $table->timestamp('opens_at'); $table->timestamp('closes_at'); $table->timestamps(); });
        Schema::create('attendances', function (Blueprint $table): void { $table->id(); $table->foreignId('attendance_session_id')->constrained()->cascadeOnDelete(); $table->foreignId('user_id')->constrained()->cascadeOnDelete(); $table->string('status')->default('present'); $table->timestamp('checked_in_at')->nullable(); $table->timestamps(); $table->unique(['attendance_session_id','user_id']); });
        Schema::create('announcements', function (Blueprint $table): void { $table->id(); $table->foreignId('lecturer_id')->constrained('users')->cascadeOnDelete(); $table->foreignId('classroom_id')->nullable()->constrained()->nullOnDelete(); $table->string('title'); $table->text('body'); $table->timestamp('published_at')->nullable(); $table->timestamps(); });
        Schema::create('trainer_kits', function (Blueprint $table): void { $table->id(); $table->unsignedTinyInteger('module_number')->unique(); $table->string('title'); $table->string('status')->default('draft'); $table->text('notes')->nullable(); $table->timestamps(); });
        Schema::create('question_bank', function (Blueprint $table): void { $table->id(); $table->foreignId('lecturer_id')->constrained('users')->cascadeOnDelete(); $table->string('module'); $table->text('question'); $table->json('options'); $table->string('correct_answer'); $table->unsignedSmallInteger('points')->default(1); $table->timestamps(); });
    }
    public function down(): void { Schema::dropIfExists('question_bank'); Schema::dropIfExists('trainer_kits'); Schema::dropIfExists('announcements'); Schema::dropIfExists('attendances'); Schema::dropIfExists('attendance_sessions'); Schema::dropIfExists('classroom_members'); Schema::dropIfExists('classrooms'); }
};
