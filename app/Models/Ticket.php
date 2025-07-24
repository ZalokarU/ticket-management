<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_template_id',
        'var_1',
        'var_2',
        'var_3',
        'event_title',
        'venue',
        'event_date',
        'price',
        'ticket_number',
        'status',
        'section',
        'row',
        'artist_performer',
        'genre',
        'additional_info',
        'qr_code',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'price' => 'decimal:2',
    ];

    /**
     * Get the template for this ticket
     */
    public function ticketTemplate(): BelongsTo
    {
        return $this->belongsTo(TicketTemplate::class);
    }

    /**
     * Generate unique ticket number
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->ticket_number)) {
                $ticket->ticket_number = strtoupper(uniqid('TKT-'));
            }

            if (empty($ticket->qr_code)) {
                $ticket->qr_code = base64_encode($ticket->ticket_number . '|' . $ticket->event_title);
            }
        });
    }

    /**
     * Check if ticket is expired
     */
    public function getIsExpiredAttribute(): bool
    {
        return $this->event_date < now();
    }

    /**
     * Get formatted event date
     */
    public function getFormattedEventDateAttribute(): string
    {
        return $this->event_date->format('M d, Y \a\t g:i A');
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Scope for active tickets
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for upcoming events
     */
    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>', now());
    }

    /**
     * Scope by template category
     */
    public function scopeByTemplateCategory($query, string $category)
    {
        return $query->whereHas('ticketTemplate', function ($q) use ($category) {
            $q->where('category', $category);
        });
    }
}
