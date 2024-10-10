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
        Schema::create('hero_items', function (Blueprint $table) {
            $table->id();
            $table->json('icon');
            $table->string('number');
            $table->json('title')->unique();
            $table->timestamps();
        });
        $items = [
            [
                'icon' => 'hero-icon-1',
                'number' => '01',
                'title' => 'Title 1',
            ],
            [
                'icon' => 'hero-icon-1',
                'number' => '01',
                'title' => 'Title 2',
            ],
            [
                'icon' => 'hero-icon-1',
                'number' => '01',
                'title' => 'Title 3',
            ],
            [
                'icon' => 'hero-icon-1',
                'number' => '01',
                'title' => 'Title 4',
            ],
            [
                'icon' => 'hero-icon-1',
                'number' => '01',
                'title' => 'Title 5',
            ],
        ];
        DB::table('hero_items')->insert($items);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_items');
    }
};
