<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\TicketTemplate;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create ticket templates
        $sportsTemplate = TicketTemplate::create([
            'name' => 'Sports Event Template',
            'view' => 'sports',
            'category' => 'sports',
            'personalization' => true,
            'description' => 'Template for sports events like football, basketball, baseball games',
            'background_color' => '#ffffff',
            'text_color' => '#1f2937',
            'design_settings' => [
                'header_text' => 'SPORTS EVENT TICKET',
                'footer_text' => 'Enjoy the game!',
                'show_qr_code' => true,
                'show_logo' => true,
                'font_family' => 'Arial, sans-serif',
                'border_style' => 'solid'
            ],
            'is_active' => true,
        ]);

        $musicTemplate = TicketTemplate::create([
            'name' => 'Music Concert Template',
            'view' => 'music',
            'category' => 'music',
            'personalization' => true,
            'description' => 'Template for music concerts, festivals, and live performances',
            'background_color' => '#fdf4ff',
            'text_color' => '#581c87',
            'design_settings' => [
                'header_text' => 'CONCERT TICKET',
                'footer_text' => 'Rock on!',
                'show_qr_code' => true,
                'show_logo' => true,
                'font_family' => 'Georgia, serif',
                'border_style' => 'solid'
            ],
            'is_active' => true,
        ]);

        $theaterTemplate = TicketTemplate::create([
            'name' => 'Theater Show Template',
            'view' => 'theater',
            'category' => 'theater',
            'personalization' => false,
            'description' => 'Template for theater shows, plays, and dramatic performances',
            'background_color' => '#fefdf8',
            'text_color' => '#92400e',
            'design_settings' => [
                'header_text' => 'THEATER TICKET',
                'footer_text' => 'Thank you for supporting the arts!',
                'show_qr_code' => true,
                'show_logo' => true,
                'font_family' => 'Times New Roman, serif',
                'border_style' => 'double'
            ],
            'is_active' => true,
        ]);

        // Create sample sports tickets
        Ticket::create([
            'ticket_template_id' => $sportsTemplate->id,
            'event_title' => 'Lakers vs Warriors',
            'venue' => 'Crypto.com Arena',
            'event_date' => now()->addDays(15)->setTime(19, 30),
            'price' => 150.00,
            'ticket_number' => 'TKT-' . strtoupper(uniqid()),
            'status' => 'active',
            'section' => 'Section 101',
            'row' => 'Row 5',
            'artist_performer' => null,
            'genre' => 'Basketball',
            'var_1' => 'John Doe',
            'var_2' => 'Seat 12',
            'var_3' => 'VIP Access',
            'additional_info' => 'Gates open 1 hour before game time',
            'qr_code' => base64_encode('TKT-LAKERS-001|Lakers vs Warriors'),
        ]);

        Ticket::create([
            'ticket_template_id' => $sportsTemplate->id,
            'event_title' => 'Manchester United vs Liverpool',
            'venue' => 'Old Trafford',
            'event_date' => now()->addDays(20)->setTime(15, 00),
            'price' => 85.00,
            'ticket_number' => 'TKT-' . strtoupper(uniqid()),
            'status' => 'active',
            'section' => 'East Stand',
            'row' => 'Row 15',
            'artist_performer' => null,
            'genre' => 'Football',
            'var_1' => 'Jane Smith',
            'var_2' => 'Seat 8',
            'var_3' => 'Season Ticket Holder',
            'additional_info' => 'Please arrive 30 minutes early for security checks',
            'qr_code' => base64_encode('TKT-MUFC-001|Manchester United vs Liverpool'),
        ]);

        // Create sample music tickets
        Ticket::create([
            'ticket_template_id' => $musicTemplate->id,
            'event_title' => 'Rock Festival 2024',
            'venue' => 'Madison Square Garden',
            'event_date' => now()->addDays(25)->setTime(20, 00),
            'price' => 120.00,
            'ticket_number' => 'TKT-' . strtoupper(uniqid()),
            'status' => 'active',
            'section' => 'General Admission',
            'row' => null,
            'artist_performer' => 'The Rolling Stones',
            'genre' => 'Rock',
            'var_1' => 'Alex Johnson',
            'var_2' => 'Standing Area A',
            'var_3' => 'Early Entry',
            'additional_info' => 'No cameras or recording devices allowed',
            'qr_code' => base64_encode('TKT-ROCK-001|Rock Festival 2024'),
        ]);

        Ticket::create([
            'ticket_template_id' => $musicTemplate->id,
            'event_title' => 'Jazz Night',
            'venue' => 'Blue Note',
            'event_date' => now()->addDays(10)->setTime(21, 00),
            'price' => 45.00,
            'ticket_number' => 'TKT-' . strtoupper(uniqid()),
            'status' => 'active',
            'section' => 'Table 5',
            'row' => null,
            'artist_performer' => 'Miles Davis Tribute Band',
            'genre' => 'Jazz',
            'var_1' => 'Sarah Wilson',
            'var_2' => 'Reserved Table',
            'var_3' => 'Dinner Included',
            'additional_info' => 'Minimum 2 drink purchase required',
            'qr_code' => base64_encode('TKT-JAZZ-001|Jazz Night'),
        ]);

        // Create sample theater tickets
        Ticket::create([
            'ticket_template_id' => $theaterTemplate->id,
            'event_title' => 'Hamlet',
            'venue' => 'Broadway Theater',
            'event_date' => now()->addDays(12)->setTime(19, 30),
            'price' => 95.00,
            'ticket_number' => 'TKT-' . strtoupper(uniqid()),
            'status' => 'active',
            'section' => 'Orchestra',
            'row' => 'Row G',
            'artist_performer' => 'Kenneth Branagh',
            'genre' => 'Drama',
            'var_1' => null,
            'var_2' => null,
            'var_3' => null,
            'additional_info' => 'Intermission at 8:45 PM. Late arrivals will be seated at intermission.',
            'qr_code' => base64_encode('TKT-HAMLET-001|Hamlet'),
        ]);

        Ticket::create([
            'ticket_template_id' => $theaterTemplate->id,
            'event_title' => 'The Lion King',
            'venue' => 'Minskoff Theatre',
            'event_date' => now()->addDays(18)->setTime(14, 00),
            'price' => 125.00,
            'ticket_number' => 'TKT-' . strtoupper(uniqid()),
            'status' => 'active',
            'section' => 'Mezzanine',
            'row' => 'Row A',
            'artist_performer' => 'Broadway Cast',
            'genre' => 'Musical',
            'var_1' => null,
            'var_2' => null,
            'var_3' => null,
            'additional_info' => 'Matinee performance. Recommended for all ages.',
            'qr_code' => base64_encode('TKT-LIONKING-001|The Lion King'),
        ]);

        // Create some past events for testing
        Ticket::create([
            'ticket_template_id' => $sportsTemplate->id,
            'event_title' => 'Super Bowl LVIII',
            'venue' => 'Allegiant Stadium',
            'event_date' => now()->subDays(30)->setTime(18, 30),
            'price' => 500.00,
            'ticket_number' => 'TKT-' . strtoupper(uniqid()),
            'status' => 'used',
            'section' => 'Section 50',
            'row' => 'Row 10',
            'artist_performer' => null,
            'genre' => 'American Football',
            'var_1' => 'Michael Brown',
            'var_2' => 'Seat 15',
            'var_3' => 'Premium Package',
            'additional_info' => 'Championship game - historic event!',
            'qr_code' => base64_encode('TKT-SB58-001|Super Bowl LVIII'),
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin user created: admin@example.com / password');
        $this->command->info('Sample tickets and templates created.');
    }
}
