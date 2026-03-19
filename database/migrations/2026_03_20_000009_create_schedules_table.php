<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('task_id')->nullable()->constrained('tasks')->nullOnDelete();
            $table->date('work_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['scheduled', 'completed'])->default('scheduled');
            $table->enum('generated_by', ['manual', 'greedy'])->default('manual');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
