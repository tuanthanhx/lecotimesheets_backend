<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('timesheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('job_id')->constrained();
            $table->foreignId('payroll_id')->nullable()->constrained();
            $table->integer('status');
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('break')->nullable();
            $table->decimal('time_worked', 10, 2)->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timesheets');
    }
};
