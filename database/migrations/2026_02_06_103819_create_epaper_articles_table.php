<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('epaper_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('edition_id')->constrained('epaper_editions')->cascadeOnDelete();
            $table->string('title');
            $table->longText('body');
            $table->string('section')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('epaper_articles');
    }
};
