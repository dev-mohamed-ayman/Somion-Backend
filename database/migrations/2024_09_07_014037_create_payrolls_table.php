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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->decimal('salary', 8, 2); // الراتب المدفوع
            $table->decimal('base_salary', 8, 2);
            $table->decimal('total_loans', 8, 2)->nullable();
            $table->decimal('total_deductions', 8, 2)->nullable();
            $table->decimal('total_bonuses', 8, 2)->nullable();
            $table->date('payment_date')->nullable(); // تاريخ الدفع
            $table->boolean('is_paid')->default(false); // حالة الدفع
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
