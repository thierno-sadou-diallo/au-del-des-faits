<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'availability_slot_id',
        'appointment_date',
        'name',
        'email',
        'phone',
        'organization',
        'subject',
        'message',
        'tracking_token',
        'status',
        'is_approved',
        'admin_notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'appointment_date' => 'date',
        'is_approved' => 'boolean',
    ];

    public function availabilitySlot(): BelongsTo
    {
        return $this->belongsTo(AvailabilitySlot::class);
    }

    // Scope pour les rendez-vous en attente d'approbation
    public function scopePendingApproval($query)
    {
        return $query->where('status', 'pending')->where('is_approved', false);
    }

    // Scope pour les rendez-vous approuvés
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }
}
