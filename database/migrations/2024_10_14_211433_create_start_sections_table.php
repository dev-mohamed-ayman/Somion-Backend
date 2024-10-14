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
        Schema::create('start_sections', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('description');
            $table->json('btn_title');
            $table->timestamps();
        });
        \App\Models\StartSection::create([
            'title' => [
                'en' => 'Welcome to Our Website',
                'de' => 'Bienvenue sur notre site',
            ],
            'description' => [
                'en' => 'Welcome to Our Website',
                'de' => 'Bienvenue sur notre site',
            ],
            'btn_title' => [
                'en' => 'Welcome to Our Website',
                'de' => 'Bienvenue sur notre site',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('start_sections');
    }
};
