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
        Schema::create('contact_sections', function (Blueprint $table) {
            $table->id();
            $table->json('first_title');
            $table->json('second_title');
            $table->json('three_title');
            $table->json('four_title');
            $table->timestamps();
        });

        \App\Models\ContactSection::query()->create([
            'first_title' => [
                'en' => 'EN',
                'de' => 'DE'
            ],
            'second_title' => [
                'en' => 'EN',
                'de' => 'DE'
            ],
            'three_title' => [
                'en' => 'EN',
                'de' => 'DE'
            ],
            'four_title' => [
                'en' => 'EN',
                'de' => 'DE'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_sections');
    }
};
