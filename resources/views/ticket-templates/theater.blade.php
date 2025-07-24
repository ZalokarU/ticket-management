<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theater Show Ticket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-2xl overflow-hidden border-l-4 border-amber-600"
         style="background-color: {{ $template->background_color ?? '#ffffff' }}; color: {{ $template->text_color ?? '#000000' }};">

        <!-- Header -->
        <div class="bg-gradient-to-r from-amber-600 to-red-600 text-white p-4 text-center">
            @if(($template->design_settings['show_logo'] ?? true))
                <div class="mb-2">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full mx-auto flex items-center justify-center">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            @endif
            <h1 class="text-xl font-bold uppercase tracking-wider">
                {{ $template->design_settings['header_text'] ?? 'Theater Ticket' }}
            </h1>
            <p class="text-sm opacity-90">{{ $template->name }}</p>
        </div>

        <!-- Main Content -->
        <div class="p-6">
            <!-- Show Title -->
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold mb-2 text-amber-800">{{ $ticket->event_title }}</h2>
                @if($ticket->artist_performer)
                    <p class="text-lg text-gray-700 mb-2">Starring: {{ $ticket->artist_performer }}</p>
                @endif
                <p class="text-gray-600 text-lg">{{ $ticket->venue }}</p>
                @if($ticket->genre)
                    <span class="inline-block bg-amber-100 text-amber-800 text-xs px-3 py-1 rounded-full mt-2 font-semibold">
                        {{ $ticket->genre }}
                    </span>
                @endif
            </div>

            <!-- Decorative Border -->
            <div class="border-t-2 border-b-2 border-amber-200 border-dashed py-4 mb-6">
                <!-- Event Details -->
                <div class="grid grid-cols-1 gap-3">
                    <div class="text-center">
                        <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Performance Date & Time</p>
                        <p class="font-bold text-lg">{{ $ticket->formatted_event_date }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Ticket Price</p>
                            <p class="font-bold text-green-600">{{ $ticket->formatted_price }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Status</p>
                            <p class="font-bold capitalize">{{ $ticket->status }}</p>
                        </div>
                    </div>

                    @if($ticket->section || $ticket->row)
                    <div class="grid grid-cols-2 gap-4">
                        @if($ticket->section)
                        <div class="text-center">
                            <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Section</p>
                            <p class="font-bold">{{ $ticket->section }}</p>
                        </div>
                        @endif
                        @if($ticket->row)
                        <div class="text-center">
                            <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Row</p>
                            <p class="font-bold">{{ $ticket->row }}</p>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- Personalization Fields -->
            @if($template->personalization)
                <x-ticket-personalization :ticket="$ticket" />
            @endif

            <!-- Additional Info -->
            @if($ticket->additional_info)
            <div class="mb-4 p-4 bg-amber-50 rounded-lg border border-amber-200">
                <p class="text-xs uppercase tracking-wide text-amber-700 font-semibold mb-2">Performance Notes</p>
                <p class="text-sm text-amber-800">{{ $ticket->additional_info }}</p>
            </div>
            @endif

            <!-- Theater Etiquette Notice -->
            <div class="mb-4 p-3 bg-red-50 rounded-lg border-l-4 border-red-400">
                <p class="text-xs text-red-700">
                    <strong>Please Note:</strong> Latecomers may not be seated until intermission.
                    Photography and recording are strictly prohibited.
                </p>
            </div>

            <!-- QR Code -->
            @if(($template->design_settings['show_qr_code'] ?? true))
            <div class="text-center mb-4">
                <div class="inline-block p-3 bg-gradient-to-br from-amber-100 to-red-100 rounded-lg border-2 border-amber-200">
                    <div class="w-20 h-20 bg-amber-800 rounded flex items-center justify-center">
                        <span class="text-white text-xs font-bold">🎭 QR</span>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2">Present at entrance</p>
            </div>
            @endif

            <!-- Ticket Number -->
            <div class="text-center border-t-2 border-amber-200 pt-4">
                <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Ticket Number</p>
                <p class="font-mono text-sm font-bold">{{ $ticket->ticket_number }}</p>
            </div>
        </div>

        <!-- Footer -->
        @if($template->design_settings['footer_text'] ?? null)
        <div class="bg-gradient-to-r from-amber-50 to-red-50 px-6 py-3 text-center border-t-2 border-amber-200">
            <p class="text-xs text-amber-700 font-medium">{{ $template->design_settings['footer_text'] }}</p>
        </div>
        @else
        <div class="bg-gradient-to-r from-amber-50 to-red-50 px-6 py-3 text-center border-t-2 border-amber-200">
            <p class="text-xs text-amber-700 font-medium">Thank you for supporting the arts!</p>
        </div>
        @endif
    </div>
</body>
</html>
