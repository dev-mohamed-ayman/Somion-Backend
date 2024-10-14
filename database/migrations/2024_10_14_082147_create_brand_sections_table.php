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
        Schema::create('brand_sections', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->timestamps();
        });
        \App\Models\BrandSection::query()->create([
            'title' => [
                'en' => 'Brand Section',
                'de' => 'Section marque',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_sections');
    }
};
