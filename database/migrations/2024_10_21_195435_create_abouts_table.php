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
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('sub_title');
            $table->json('description');
            $table->json('last_title');
            $table->json('items');
            $table->json('our_mission');
            $table->timestamps();
        });

        \App\Models\About::query()->create([
            'title' => [
                'en' => 'AR',
                'de' => 'DE'
            ],
            'sub_title' => [
                'en' => 'AR',
                'de' => 'DE'
            ],
            'description' => [
                'en' => 'AR',
                'de' => 'DE'
            ],
            'last_title' => [
                'en' => [
                    'title en 1',
                    'title en 2',
                    'title en 3',
                ],
                'de' => [
                    'title de 1',
                    'title de 2',
                    'title de 3',
                ]
            ],
            'items' => [
                'en' => [
                    [
                        'title',
                        'description'
                    ],
                    [
                        'title',
                        'description'
                    ],
                ],
                'de' => [
                    [
                        'title',
                        'description'
                    ],
                    [
                        'title',
                        'description'
                    ],
                ]
            ],
            'our_mission' => [
                'en' => 'AR',
                'de' => 'DE'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
