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
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_available' => 'boolean',
    ];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function isAvailable(): bool
    {
        return $this->is_available && $this->current_appointments < $this->max_appointments;
    }
}
