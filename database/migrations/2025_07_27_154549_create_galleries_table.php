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
        // Images Table (Polymorphic)
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Polymorphic relation: imageable_id + imageable_type
            $table->morphs('imageable'); // replaces sikh_id, business_id, etc.

            $table->string('path'); // Image path (relative or full)
            $table->string('caption')->nullable(); // Optional caption
            $table->timestamps();
        });

        // Video Links Table (Polymorphic)
        Schema::create('video_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Polymorphic relation: videoable_id + videoable_type
            $table->morphs('videoable'); // replaces sikh_id, business_id, etc.

            $table->string('link'); // YouTube or external video link
            $table->string('caption')->nullable(); // Optional caption
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_links');
        Schema::dropIfExists('images');
    }
};
