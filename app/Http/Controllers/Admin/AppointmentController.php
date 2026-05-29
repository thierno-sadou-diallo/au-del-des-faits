<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AvailabilitySlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\AppointmentConfirmed;
use Illuminate\Support\Facades\Notification;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with('availabilitySlot')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.appointments.index', [
            'appointments' => $appointments,
        ]);
    }

    public function show(Appointment $appointment)
    {
        auth()->user()->unreadNotifications()
            ->where('data->appointment_id', $appointment->id)
            ->update(['read_at' => now()]);

        $slots = AvailabilitySlot::where(function ($query) use ($appointment) {
            $query->where('is_available', true);

            if ($appointment->availability_slot_id) {
                $query->orWhere('id', $appointment->availability_slot_id);
            }
        })
        ->orderBy('start_time')
        ->get();

        return view('admin.appointments.show', [
            'appointment' => $appointment,
            'slots' => $slots,
        ]);
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $appointment->update($validated);

        if ($validated['status'] === 'cancelled' && $appointment->availabilitySlot) {
            $appointment->availabilitySlot->decrement('current_appointments');
            $appointment->update(['availability_slot_id' => null]);
        }

        // Notify user when appointment is confirmed
        if ($validated['status'] === 'confirmed') {
            try {
                Notification::route('mail', $appointment->email)->notify(new AppointmentConfirmed($appointment));
            } catch (\Exception $e) {
                // ignore notification failures to avoid breaking admin flow
            }
        }

        return back()->with('status', 'Statut du rendez-vous mis à jour avec succès.');
    }

    public function schedule(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'availability_slot_id' => 'required|exists:availability_slots,id',
        ]);

        try {
            $appointment = DB::transaction(function () use ($validated, $appointment) {
                $slot = AvailabilitySlot::lockForUpdate()->findOrFail($validated['availability_slot_id']);

                if (!$slot->is_available || ($slot->current_appointments >= $slot->max_appointments && $appointment->availability_slot_id !== $slot->id)) {
                    throw new \RuntimeException('Ce créneau n\'est plus disponible.');
                }

                if ($appointment->availability_slot_id === $slot->id) {
                    $appointment->status = 'confirmed';
                    $appointment->save();
                    return $appointment;
                }

                if ($appointment->availabilitySlot) {
                    $appointment->availabilitySlot->decrement('current_appointments');
                }

                $appointment->availability_slot_id = $slot->id;
                $appointment->status = 'confirmed';
                $appointment->save();

                $slot->increment('current_appointments');

                return $appointment;
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        // Notify the requester
        try {
            Notification::route('mail', $appointment->email)->notify(new AppointmentConfirmed($appointment));
        } catch (\Exception $e) {
            // ignore
        }

        return back()->with('status', 'Le rendez-vous a été programmé et le demandeur a été notifié.');
    }

    public function destroy(Appointment $appointment)
    {
        // Décrémenter le nombre de rendez-vous du créneau
        if ($appointment->availabilitySlot) {
            $appointment->availabilitySlot->decrement('current_appointments');
        }

        $appointment->delete();

        return back()->with('status', 'Rendez-vous supprimé avec succès.');
    }
}
