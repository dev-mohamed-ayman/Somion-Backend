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
        Schema::create('imprints', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('body');
            $table->timestamps();
        });
        \App\Models\Imprint::query()->create([
            'title' => [
                'en' => 'Imprint',
                'de' => 'Mentions légales',
            ],
            'body' => [
                'en' => 'Imprint',
                'de' => 'Mentions légales',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imprints');
    }
};
