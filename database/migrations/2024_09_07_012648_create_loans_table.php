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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->decimal('total_amount', 8, 2); // إجمالي مبلغ السلفة
            $table->decimal('remaining_amount', 8, 2); // المبلغ المتبقي
            $table->integer('installments_count'); // عدد الأقساط الكلية
            $table->integer('installments_paid')->default(0); // عدد الأقساط المدفوعة// المبلغ المتبقي
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
