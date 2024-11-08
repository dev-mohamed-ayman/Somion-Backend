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
        Schema::create('task_comment_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_comment_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->text('name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_comment_files');
    }
};
