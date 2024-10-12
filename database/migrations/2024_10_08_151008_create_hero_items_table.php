<?php

use App\Models\HeroItem;
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
            $table->string('number');
            $table->json('title');
            $table->timestamps();
        });
        $items = [
            [
                'number' => '01',
                'title' => [
                    'en' => 'Title 1',
                    'de' => 'Title 1',
                ],
            ],
            [
                'number' => '01',
                'title' => [
                    'en' => 'Title 2',
                    'de' => 'Title 2',
                ],
            ],
            [
                'number' => '01',
                'title' => [
                    'en' => 'Title 3',
                    'de' => 'Title 3',
                ],
            ],
            [
                'number' => '01',
                'title' => [
                    'en' => 'Title 4',
                    'de' => 'Title 4',
                ],
            ],
            [
                'number' => '01',
                'title' => [
                    'en' => 'Title 5',
                    'de' => 'Title 5',
                ],
            ],
        ];
        foreach ($items as $item) {
            HeroItem::create($item);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_items');
    }
};
