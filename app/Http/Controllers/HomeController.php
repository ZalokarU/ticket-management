<?php
namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketTemplate;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the homepage with ticket overview
     */
    public function index(): View
    {
        // Get tickets grouped by template category
        $sportsTickets = Ticket::byTemplateCategory('sports')
            ->with('ticketTemplate')
            ->active()
            ->upcoming()
            ->orderBy('event_date')
            ->limit(6)
            ->get();

        $musicTickets = Ticket::byTemplateCategory('music')
            ->with('ticketTemplate')
            ->active()
            ->upcoming()
            ->orderBy('event_date')
            ->limit(6)
            ->get();

        $theaterTickets = Ticket::byTemplateCategory('theater')
            ->with('ticketTemplate')
            ->active()
            ->upcoming()
            ->orderBy('event_date')
            ->limit(6)
            ->get();

        // Get statistics
        $stats = [
            'total_tickets' => Ticket::active()->count(),
            'upcoming_events' => Ticket::active()->upcoming()->count(),
            'sports_events' => $sportsTickets->count(),
            'music_events' => $musicTickets->count(),
            'theater_events' => $theaterTickets->count(),
            'active_templates' => TicketTemplate::active()->count(),
        ];

        // Get recent tickets for activity feed
        $recentTickets = Ticket::with('ticketTemplate')
            ->active()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('welcome', compact(
            'sportsTickets',
            'musicTickets',
            'theaterTickets',
            'stats',
            'recentTickets'
        ));
    }

    /**
     * Show ticket details
     */
    public function showTicket(Ticket $ticket): View
    {
        $ticket->load('ticketTemplate');

        // Determine which template view to use
        $templateView = match ($ticket->ticketTemplate->view) {
            'sports' => 'ticket-templates.sports',
            'music' => 'ticket-templates.music',
            'theater' => 'ticket-templates.theater',
            default => 'ticket-templates.sports'
        };

        return view($templateView, [
            'ticket' => $ticket,
            'template' => $ticket->ticketTemplate
        ]);
    }

    /**
     * Get tickets by category for AJAX requests
     */
    public function getTicketsByCategory(Request $request, string $category)
    {
        $tickets = Ticket::byTemplateCategory($category)
            ->with('ticketTemplate')
            ->active()
            ->upcoming()
            ->orderBy('event_date')
            ->paginate(12);

        if ($request->ajax()) {
            return response()->json([
                'tickets' => $tickets->items(),
                'pagination' => [
                    'current_page' => $tickets->currentPage(),
                    'last_page' => $tickets->lastPage(),
                    'per_page' => $tickets->perPage(),
                    'total' => $tickets->total(),
                ]
            ]);
        }

        return view('tickets.category', [
            'tickets' => $tickets,
            'category' => $category,
            'categoryName' => ucfirst($category)
        ]);
    }
}
