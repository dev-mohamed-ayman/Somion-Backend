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
        Schema::create('why_sections', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->timestamps();
        });
        \App\Models\WhySection::query()->create([
            'title' => [
                'en' => 'Why Choose Us',
                'de' => 'Por qué Elegirnos'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('why_sections');
    }
};
