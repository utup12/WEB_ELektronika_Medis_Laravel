<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void { Schema::create('attendance_manual_entries', function (Blueprint $table): void { $table->id(); $table->foreignId('attendance_session_id')->constrained()->cascadeOnDelete(); $table->string('student_name'); $table->string('status'); $table->timestamps(); }); }
    public function down(): void { Schema::dropIfExists('attendance_manual_entries'); }
};
