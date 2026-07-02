<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AvailabilitySlot extends Model
{
    protected $fillable = [
        'start_time',
        'end_time',
        'is_available',
        'description',
        'max_appointments',
        'current_appointments',
        'available_date',
        'slot_type',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_available' => 'boolean',
        'available_date' => 'date',
    ];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function isAvailable(): bool
    {
        // Pour les anciens créneaux avec heures
        if ($this->start_time && $this->end_time) {
            return $this->is_available && $this->current_appointments < $this->max_appointments;
        }
        // Pour les nouveaux créneaux par date
        return $this->slot_type === 'available' && $this->available_date->isFuture();
    }

    // Scope pour les jours disponibles
    public function scopeAvailableDays($query)
    {
        return $query->where('slot_type', 'available')
            ->where('available_date', '>=', now()->toDateString());
    }

    // Scope pour les demandes en attente
    public function scopePendingRequests($query)
    {
        return $query->where('slot_type', 'request');
    }
}
