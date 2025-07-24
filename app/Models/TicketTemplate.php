<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TicketTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'view',
        'personalization',
        'category',
        'description',
        'background_color',
        'text_color',
        'design_settings',
        'is_active',
    ];

    protected $casts = [
        'personalization' => 'boolean',
        'is_active' => 'boolean',
        'design_settings' => 'array',
    ];

    /**
     * Get all tickets for this template
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Get active tickets count
     */
    public function getActiveTicketsCountAttribute(): int
    {
        return $this->tickets()->where('status', 'active')->count();
    }

    /**
     * Get used tickets count
     */
    public function getUsedTicketsCountAttribute(): int
    {
        return $this->tickets()->where('status', 'used')->count();
    }

    /**
     * Scope to get only active templates
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get templates by category
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
}
