{{-- resources/views/components/ticket-personalization.blade.php --}}
@props(['ticket'])

@if($ticket->ticketTemplate->personalization && ($ticket->var_1 || $ticket->var_2 || $ticket->var_3))
<div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
    <h4 class="text-sm font-semibold text-blue-800 mb-3 uppercase tracking-wide">
        Personal Details
    </h4>

    <div class="space-y-2">
        @if($ticket->var_1)
        <div class="flex justify-between items-center">
            <span class="text-sm text-blue-600 font-medium">
                @switch($ticket->ticketTemplate->category)
                    @case('sports')
                        Attendee Name:
                        @break
                    @case('music')
                        Guest Name:
                        @break
                    @case('theater')
                        Patron Name:
                        @break
                    @default
                        Name:
                @endswitch
            </span>
            <span class="text-sm font-bold text-blue-900">{{ $ticket->var_1 }}</span>
        </div>
        @endif

        @if($ticket->var_2)
        <div class="flex justify-between items-center">
            <span class="text-sm text-blue-600 font-medium">
                @switch($ticket->ticketTemplate->category)
                    @case('sports')
                        Seat Number:
                        @break
                    @case('music')
                        Standing Area:
                        @break
                    @case('theater')
                        Seat Assignment:
                        @break
                    @default
                        Location:
                @endswitch
            </span>
            <span class="text-sm font-bold text-blue-900">{{ $ticket->var_2 }}</span>
        </div>
        @endif

        @if($ticket->var_3)
        <div class="flex justify-between items-center">
            <span class="text-sm text-blue-600 font-medium">
                @switch($ticket->ticketTemplate->category)
                    @case('sports')
                        Special Access:
                        @break
                    @case('music')
                        VIP Status:
                        @break
                    @case('theater')
                        Special Notes:
                        @break
                    @default
                        Notes:
                @endswitch
            </span>
            <span class="text-sm font-bold text-blue-900">{{ $ticket->var_3 }}</span>
        </div>
        @endif
    </div>
</div>
@endif
