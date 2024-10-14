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
        Schema::create('footers', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->json('emails');
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('x')->nullable();
            $table->string('be')->nullable();
            $table->json('location')->nullable();
            $table->json('subscription_paragraph')->nullable();
            $table->json('copyright');
            $table->timestamps();
        });
        \App\Models\Footer::query()->create([
            'logo' => 'Logo',
            'emails' => [
                'Info@Somion.ch',
                'markiting@somion.ch'
            ],
            'phone' => '1234',
            'whatsapp' => '1234',
            'instagram' => 'http://www.instagram.com',
            'linkedin' => 'http://www.linked.com',
            'x' => 'http://www.x.com',
            'be' => 'http://www.be.com',
            'location' => [
                'en' => 'test',
                'de' => 'test',
            ],
            'subscription_paragraph' => [
                'en' => 'test',
                'de' => 'test',
            ],
            'copyright' => [
                'en' => 'test',
                'de' => 'test',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footers');
    }
};
