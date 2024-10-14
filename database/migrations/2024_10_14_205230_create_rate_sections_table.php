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
        Schema::create('rate_sections', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('sub_title');
            $table->json('paragraph');
            $table->timestamps();
        });
        \App\Models\RateSection::create([
            'title' => [
                'en' => 'Our Rates',
                'de' => 'Nuestros Precios',
            ],
           'sub_title' => [
               'en' => 'Our Rates',
               'de' => 'Nuestros Precios',
           ],
            'paragraph' => [
                'en' => 'Our Rates',
                'de' => 'Nuestros Precios',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rate_sections');
    }
};
