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
        Schema::create('epaper_regions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('epaper_pages')->cascadeOnDelete();
            $table->foreignId('article_id')->nullable()->constrained('epaper_articles')->nullOnDelete();
            $table->decimal('x', 8, 6);
            $table->decimal('y', 8, 6);
            $table->decimal('w', 8, 6);
            $table->decimal('h', 8, 6);
            $table->string('label')->nullable();
            $table->string('type')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('epaper_regions');
    }
};
