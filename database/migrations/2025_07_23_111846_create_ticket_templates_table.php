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
        Schema::create('ticket_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Template name (Sports Event, Music Concert, Theater Show)
            $table->enum('view', ['sports', 'music', 'theater']); // Blade template identifier
            $table->boolean('personalization')->default(false); // Show personalization fields
            $table->string('category'); // Event category for grouping
            $table->text('description')->nullable(); // Template description
            $table->string('background_color')->default('#ffffff'); // Template background color
            $table->string('text_color')->default('#000000'); // Template text color
            $table->json('design_settings')->nullable(); // Additional design settings as JSON
            $table->boolean('is_active')->default(true); // Template active status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_templates');
    }
};
