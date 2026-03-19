<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scheduling_rules', function (Blueprint $table) {
            $table->id();
            $table->integer('max_hours_per_week')->default(40);
            $table->integer('max_tasks_per_day')->default(3);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scheduling_rules');
    }
};
