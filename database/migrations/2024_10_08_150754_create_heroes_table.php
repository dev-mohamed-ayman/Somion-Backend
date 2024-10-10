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
        Schema::create('heroes', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('short_description');
            $table->json('btn_title');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::table('heroes')->insert([
            'title' => [
                'en' => 'Hero Title',
                'de' => 'Hero Title',
            ],
            'short_description' => [
                'en' => 'Short Description',
                'de' => 'Short Description',
            ],
            'btn_title' => [
                'en' => 'Button Title',
                'de' => 'Button Title',
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heroes');
    }
};
