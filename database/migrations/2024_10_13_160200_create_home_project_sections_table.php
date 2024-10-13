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
        Schema::create('home_project_sections', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('description');
            $table->json('sub_title');
            $table->timestamps();
        });
        \App\Models\HomeProjectSection::query()->create([
            'title' => [
                'en' => 'title test',
                'de' => 'title test',
            ],
            'description' => [
                'en' => 'description test',
                'de' => 'description test',
            ],
            'sub_title' => [
                'en' => 'sub_title test',
                'de' => 'sub_title test',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_project_sections');
    }
};
