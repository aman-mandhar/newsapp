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
        Schema::create('epaper_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('edition_id')->constrained('epaper_editions')->cascadeOnDelete();
            $table->unsignedInteger('page_no');
            $table->string('image_path');
            $table->string('thumb_path');
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->timestamps();

            $table->unique(['edition_id', 'page_no']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('epaper_pages');
    }
};
