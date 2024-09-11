<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->longText('notes')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('currency')->default('USD');
            $table->decimal('total_amount', 15, 2);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->decimal('remaining_amount', 15, 2)->virtualAs('total_amount - paid_amount');
            $table->enum('payment_status', ['pending', 'partially_paid', 'paid'])->default('pending');
            $table->enum('project_status', ['not_started', 'in_progress', 'completed', 'on_hold'])->default('not_started');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
