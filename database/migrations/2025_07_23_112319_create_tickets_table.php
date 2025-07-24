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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_template_id')->constrained()->onDelete('cascade');

            // Personalization variables
            $table->string('var_1')->nullable(); // e.g., Attendee Name
            $table->string('var_2')->nullable(); // e.g., Seat Number
            $table->string('var_3')->nullable(); // e.g., Special Instructions

            // Event details
            $table->string('event_title'); // Event name
            $table->string('venue'); // Event venue
            $table->dateTime('event_date'); // Event date and time
            $table->decimal('price', 8, 2); // Ticket price
            $table->string('ticket_number')->unique(); // Unique ticket identifier
            $table->enum('status', ['active', 'used', 'cancelled'])->default('active');

            // Additional event-specific fields
            $table->string('section')->nullable(); // Seating section (for sports/theater)
            $table->string('row')->nullable(); // Seating row
            $table->string('artist_performer')->nullable(); // Main artist/performer (for music/theater)
            $table->string('genre')->nullable(); // Event genre
            $table->text('additional_info')->nullable(); // Extra information

            // QR code for digital verification
            $table->string('qr_code')->nullable(); // QR code data

            $table->timestamps();

            // Indexes for better performance
            $table->index(['event_date']);
            $table->index(['status']);
            $table->index(['ticket_template_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
