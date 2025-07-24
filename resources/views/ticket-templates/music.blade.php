<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Concert Ticket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-2xl overflow-hidden border-l-4 border-purple-600"
         style="background-color: {{ $template->background_color ?? '#ffffff' }}; color: {{ $template->text_color ?? '#000000' }};">

        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white p-4 text-center">
            @if(($template->design_settings['show_logo'] ?? true))
                <div class="mb-2">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full mx-auto flex items-center justify-center">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM15.657 6.343a1 1 0 011.414 0A9.972 9.972 0 0119 12a9.972 9.972 0 01-1.929 5.657 1 1 0 11-1.414-1.414A7.971 7.971 0 0017 12c0-2.21-.895-4.21-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 12a5.983 5.983 0 01-.757 2.829 1 1 0 01-1.415-1.415A3.987 3.987 0 0013 12a3.987 3.987 0 00-.172-1.414 1 1 0 010-1.415z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            @endif
            <h1 class="text-xl font-bold uppercase tracking-wider">
                {{ $template->design_settings['header_text'] ?? 'Concert Ticket' }}
            </h1>
            <p class="text-sm opacity-90">{{ $template->name }}</p>
        </div>

        <!-- Main Content -->
        <div class="p-6">
            <!-- Artist Name -->
            <div class="text-center mb-6">
                @if($ticket->artist_performer)
                    <h2 class="text-3xl font-bold mb-2 text-purple-800">{{ $ticket->artist_performer }}</h2>
                @endif
                <h3 class="text-xl font-semibold mb-2">{{ $ticket->event_title }}</h3>
                <p class="text-gray-600 text-lg">{{ $ticket->venue }}</p>
                @if($ticket->genre)
                    <span class="inline-block bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full mt-2">
                        {{ $ticket->genre }}
                    </span>
                @endif
            </div>

            <!-- Event Info -->
            <div class="space-y-3 mb-6">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-600 uppercase tracking-wide">Date & Time</span>
                    <span class="font-bold">{{ $ticket->formatted_event_date }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-600 uppercase tracking-wide">Price</span>
                    <span class="font-bold text-green-600">{{ $ticket->formatted_price }}</span>
                </div>
                @if($ticket->section)
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-600 uppercase tracking-wide">Section</span>
                    <span class="font-bold">{{ $ticket->section }}</span>
                </div>
                @endif
                @if($ticket->row)
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-600 uppercase tracking-wide">Row</span>
                    <span class="font-bold">{{ $ticket->row }}</span>
                </div>
                @endif
            </div>

            <!-- Personalization Fields -->
            @if($template->personalization)
                <x-ticket-personalization :ticket="$ticket" />
            @endif

            <!-- Additional Info -->
            @if($ticket->additional_info)
            <div class="mb-4 p-3 bg-purple-50 rounded-lg border-l-4 border-purple-400">
                <p class="text-xs uppercase tracking-wide text-purple-600 font-semibold mb-1">Special Notes</p>
                <p class="text-sm text-purple-800">{{ $ticket->additional_info }}</p>
            </div>
            @endif

            <!-- QR Code -->
            @if(($template->design_settings['show_qr_code'] ?? true))
            <div class="text-center mb-4">
                <div class="inline-block p-3 bg-gradient-to-br from-purple-100 to-pink-100 rounded-lg">
                    <div class="w-20 h-20 bg-purple-800 rounded flex items-center justify-center">
                        <span class="text-white text-xs font-bold">♪ QR ♪</span>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2">Scan for entry</p>
            </div>
            @endif

            <!-- Ticket Number -->
            <div class="text-center border-t pt-4">
                <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Ticket Number</p>
                <p class="font-mono text-sm font-bold">{{ $ticket->ticket_number }}</p>
            </div>
        </div>

        <!-- Footer -->
        @if($template->design_settings['footer_text'] ?? null)
        <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-3 text-center border-t">
            <p class="text-xs text-purple-600">{{ $template->design_settings['footer_text'] }}</p>
        </div>
        @endif
    </div>
</body>
</html>
