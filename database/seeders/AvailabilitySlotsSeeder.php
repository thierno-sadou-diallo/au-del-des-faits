<?php

namespace Database\Seeders;

use App\Models\AvailabilitySlot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AvailabilitySlotsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        
        // Créer 5 créneaux de disponibilité pour les prochains jours
        for ($i = 1; $i <= 5; $i++) {
            AvailabilitySlot::create([
                'start_time' => $now->copy()->addDays($i)->setTime(9, 0),
                'end_time' => $now->copy()->addDays($i)->setTime(10, 0),
                'is_available' => true,
                'description' => 'Créneau de 1 heure - Appel visio',
                'max_appointments' => 2,
                'current_appointments' => 0,
            ]);
            
            AvailabilitySlot::create([
                'start_time' => $now->copy()->addDays($i)->setTime(14, 0),
                'end_time' => $now->copy()->addDays($i)->setTime(15, 0),
                'is_available' => true,
                'description' => 'Créneau de 1 heure - Appel visio',
                'max_appointments' => 2,
                'current_appointments' => 0,
            ]);
            
            AvailabilitySlot::create([
                'start_time' => $now->copy()->addDays($i)->setTime(16, 0),
                'end_time' => $now->copy()->addDays($i)->setTime(17, 30),
                'is_available' => true,
                'description' => 'Créneau de 1h30 - Réunion approfondie',
                'max_appointments' => 1,
                'current_appointments' => 0,
            ]);
        }
    }
}
