<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Ticket System') }} - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 font-sans antialiased">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-gray-900">
                            <i class="fas fa-ticket-alt text-blue-600 mr-2"></i>
                            Ticket System
                        </h1>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        <a href="/admin"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200">
                            <i class="fas fa-cog mr-2"></i>Admin Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium">
                                <i class="fas fa-sign-out-alt mr-1"></i>Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium">
                            <i class="fas fa-sign-in-alt mr-1"></i>Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h2 class="text-4xl font-bold mb-4">Event Ticket Management System</h2>
                <p class="text-xl text-blue-100 mb-8">Manage and view all your event tickets in one place</p>

                <!-- Stats Cards -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">
                    <div class="bg-white bg-opacity-20 rounded-lg p-4">
                        <div class="text-2xl font-bold">{{ $stats['total_tickets'] }}</div>
                        <div class="text-sm text-blue-100">Total Tickets</div>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg p-4">
                        <div class="text-2xl font-bold">{{ $stats['upcoming_events'] }}</div>
                        <div class="text-sm text-blue-100">Upcoming Events</div>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg p-4">
                        <div class="text-2xl font-bold">{{ $stats['active_templates'] }}</div>
                        <div class="text-sm text-blue-100">Active Templates</div>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg p-4">
                        <div class="text-2xl font-bold">3</div>
                        <div class="text-sm text-blue-100">Categories</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Category Tabs -->
        <div class="mb-8" x-data="{ activeTab: 'sports' }">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button @click="activeTab = 'sports'"
                        :class="activeTab === 'sports' ? 'border-blue-500 text-blue-600' :
                            'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition duration-200">
                        <i class="fas fa-football-ball mr-2"></i>
                        Sports Events ({{ $stats['sports_events'] }})
                    </button>
                    <button @click="activeTab = 'music'"
                        :class="activeTab === 'music' ? 'border-purple-500 text-purple-600' :
                            'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition duration-200">
                        <i class="fas fa-music mr-2"></i>
                        Music Concerts ({{ $stats['music_events'] }})
                    </button>
                    <button @click="activeTab = 'theater'"
                        :class="activeTab === 'theater' ? 'border-amber-500 text-amber-600' :
                            'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition duration-200">
                        <i class="fas fa-theater-masks mr-2"></i>
                        Theater Shows ({{ $stats['theater_events'] }})
                    </button>
                </nav>
            </div>

            <!-- Sports Events -->
            <div x-show="activeTab === 'sports'" class="mt-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-football-ball text-blue-600 mr-2"></i>Sports Events
                </h3>
                @if ($sportsTickets->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($sportsTickets as $ticket)
                            <div
                                class="bg-white rounded-lg shadow-md hover:shadow-lg transition duration-200 border-l-4 border-blue-500">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-3">
                                        <span
                                            class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-semibold">
                                            {{ $ticket->ticketTemplate->name }}
                                        </span>
                                        <span
                                            class="text-lg font-bold text-green-600">{{ $ticket->formatted_price }}</span>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $ticket->event_title }}
                                    </h4>
                                    <p class="text-gray-600 mb-2">
                                        <i class="fas fa-map-marker-alt mr-1"></i>{{ $ticket->venue }}
                                    </p>
                                    <p class="text-gray-600 mb-4">
                                        <i class="fas fa-calendar mr-1"></i>{{ $ticket->formatted_event_date }}
                                    </p>
                                    <div class="flex justify-between items-center">
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                            {{ ucfirst($ticket->status) }}
                                        </span>
                                        <a href="{{ route('ticket.show', $ticket) }}"
                                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            View Ticket <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-football-ball text-gray-300 text-6xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Sports Events</h3>
                        <p class="text-gray-500">No upcoming sports events found.</p>
                    </div>
                @endif
            </div>

            <!-- Music Events -->
            <div x-show="activeTab === 'music'" class="mt-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-music text-purple-600 mr-2"></i>Music Concerts
                </h3>
                @if ($musicTickets->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($musicTickets as $ticket)
                            <div
                                class="bg-white rounded-lg shadow-md hover:shadow-lg transition duration-200 border-l-4 border-purple-500">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-3">
                                        <span
                                            class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full font-semibold">
                                            {{ $ticket->ticketTemplate->name }}
                                        </span>
                                        <span
                                            class="text-lg font-bold text-green-600">{{ $ticket->formatted_price }}</span>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $ticket->event_title }}
                                    </h4>
                                    @if ($ticket->artist_performer)
                                        <p class="text-purple-600 font-medium mb-2">{{ $ticket->artist_performer }}
                                        </p>
                                    @endif
                                    <p class="text-gray-600 mb-2">
                                        <i class="fas fa-map-marker-alt mr-1"></i>{{ $ticket->venue }}
                                    </p>
                                    <p class="text-gray-600 mb-4">
                                        <i class="fas fa-calendar mr-1"></i>{{ $ticket->formatted_event_date }}
                                    </p>
                                    <div class="flex justify-between items-center">
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                            {{ ucfirst($ticket->status) }}
                                        </span>
                                        <a href="{{ route('ticket.show', $ticket) }}"
                                            class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                            View Ticket <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-music text-gray-300 text-6xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Music Concerts</h3>
                        <p class="text-gray-500">No upcoming music concerts found.</p>
                    </div>
                @endif
            </div>

            <!-- Theater Events -->
            <div x-show="activeTab === 'theater'" class="mt-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-theater-masks text-amber-600 mr-2"></i>Theater Shows
                </h3>
                @if ($theaterTickets->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($theaterTickets as $ticket)
                            <div
                                class="bg-white rounded-lg shadow-md hover:shadow-lg transition duration-200 border-l-4 border-amber-500">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-3">
                                        <span
                                            class="bg-amber-100 text-amber-800 text-xs px-2 py-1 rounded-full font-semibold">
                                            {{ $ticket->ticketTemplate->name }}
                                        </span>
                                        <span
                                            class="text-lg font-bold text-green-600">{{ $ticket->formatted_price }}</span>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $ticket->event_title }}
                                    </h4>
                                    @if ($ticket->artist_performer)
                                        <p class="text-amber-600 font-medium mb-2">Starring:
                                            {{ $ticket->artist_performer }}</p>
                                    @endif
                                    <p class="text-gray-600 mb-2">
                                        <i class="fas fa-map-marker-alt mr-1"></i>{{ $ticket->venue }}
                                    </p>
                                    <p class="text-gray-600 mb-4">
                                        <i class="fas fa-calendar mr-1"></i>{{ $ticket->formatted_event_date }}
                                    </p>
                                    <div class="flex justify-between items-center">
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                            {{ ucfirst($ticket->status) }}
                                        </span>
                                        <a href="{{ route('ticket.show', $ticket) }}"
                                            class="text-amber-600 hover:text-amber-800 text-sm font-medium">
                                            View Ticket <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-theater-masks text-gray-300 text-6xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Theater Shows</h3>
                        <p class="text-gray-500">No upcoming theater shows found.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Activity -->
        @if ($recentTickets->count() > 0)
            <div class="mt-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">
                    <i class="fas fa-clock text-gray-600 mr-2"></i>Recent Activity
                </h3>
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach ($recentTickets as $ticket)
                                <div
                                    class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition duration-200">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-10 h-10 rounded-full flex items-center justify-center
                                           {{ $ticket->ticketTemplate->category === 'sports'
                                               ? 'bg-blue-100 text-blue-600'
                                               : ($ticket->ticketTemplate->category === 'music'
                                                   ? 'bg-purple-100 text-purple-600'
                                                   : 'bg-amber-100 text-amber-600') }}">
                                                <i
                                                    class="fas {{ $ticket->ticketTemplate->category === 'sports'
                                                        ? 'fa-football-ball'
                                                        : ($ticket->ticketTemplate->category === 'music'
                                                            ? 'fa-music'
                                                            : 'fa-theater-masks') }}"></i>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $ticket->event_title }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ $ticket->venue }} • {{ $ticket->formatted_event_date }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <span class="text-sm text-gray-500">
                                            {{ $ticket->created_at->diffForHumans() }}
                                        </span>
                                        <a href="{{ route('ticket.show', $ticket) }}"
                                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            View Ticket <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <p class="text-gray-400">
                    &copy; {{ date('Y') }} Ticket Management System.
                </p>
            </div>
        </div>
    </footer>
</body>

</html>
