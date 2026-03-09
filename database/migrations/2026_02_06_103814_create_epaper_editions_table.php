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
        Schema::create('epaper_editions', function (Blueprint $table) {
            $table->id();
            $table->string('edition_name');
            $table->date('issue_date');
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->string('pdf_path');
            $table->unsignedInteger('total_pages')->default(0);
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('epaper_editions');
    }
};
