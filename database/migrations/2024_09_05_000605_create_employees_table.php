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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('employee_job_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('employment_status_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female']);
            $table->string('address')->nullable();
            $table->date('joining_date');
            $table->integer('salary');
            $table->text('payment_information');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
