<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Event Ticket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-2xl overflow-hidden border-l-4 border-blue-600"
         style="background-color: {{ $template->background_color ?? '#ffffff' }}; color: {{ $template->text_color ?? '#000000' }};">

        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-4 text-center">
            @if(($template->design_settings['show_logo'] ?? true))
                <div class="mb-2">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full mx-auto flex items-center justify-center">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            @endif
            <h1 class="text-xl font-bold uppercase tracking-wider">
                {{ $template->design_settings['header_text'] ?? 'Sports Event Ticket' }}
            </h1>
            <p class="text-sm opacity-90">{{ $template->name }}</p>
        </div>

        <!-- Main Content -->
        <div class="p-6">
            <!-- Event Details -->
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold mb-2">{{ $ticket->event_title }}</h2>
                <p class="text-gray-600 text-lg">{{ $ticket->venue }}</p>
            </div>

            <!-- Event Info Grid -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Date & Time</p>
                    <p class="font-bold">{{ $ticket->formatted_event_date }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Price</p>
                    <p class="font-bold text-green-600">{{ $ticket->formatted_price }}</p>
                </div>
                @if($ticket->section)
                <div>
                    <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Section</p>
                    <p class="font-bold">{{ $ticket->section }}</p>
                </div>
                @endif
                @if($ticket->row)
                <div>
                    <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Row</p>
                    <p class="font-bold">{{ $ticket->row }}</p>
                </div>
                @endif
            </div>

            <!-- Personalization Fields -->
            @if($template->personalization)
                <x-ticket-personalization :ticket="$ticket" />
            @endif

            <!-- Additional Info -->
            @if($ticket->additional_info)
            <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold mb-1">Additional Information</p>
                <p class="text-sm">{{ $ticket->additional_info }}</p>
            </div>
            @endif

            <!-- QR Code -->
            @if(($template->design_settings['show_qr_code'] ?? true))
            <div class="text-center mb-4">
                <div class="inline-block p-2 bg-gray-100 rounded-lg">
                    <div class="w-20 h-20 bg-black opacity-80 rounded flex items-center justify-center">
                        <span class="text-white text-xs">QR</span>
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
        <div class="bg-gray-50 px-6 py-3 text-center border-t">
            <p class="text-xs text-gray-600">{{ $template->design_settings['footer_text'] }}</p>
        </div>
        @endif
    </div>
</body>
</html>
