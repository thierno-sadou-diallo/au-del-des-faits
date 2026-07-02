<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AvailabilitySlot;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AvailabilitySlotController extends Controller
{
    public function index()
    {
        $month = request('month', now()->month);
        $year = request('year', now()->year);
        $currentDate = Carbon::createFromDate($year, $month, 1);

        // Récupérer les jours disponibles du mois
        $availableDays = AvailabilitySlot::where('slot_type', 'available')
            ->whereYear('available_date', $year)
            ->whereMonth('available_date', $month)
            ->pluck('available_date')
            ->map(fn($date) => $date->day)
            ->toArray();

        // Récupérer les demandes en attente
        $pendingRequests = Appointment::pendingApproval()
            ->distinct()
            ->pluck('appointment_date')
            ->map(fn($date) => $date->format('Y-m-d'))
            ->toArray();

        $slots = AvailabilitySlot::orderBy('start_time', 'desc')->paginate(20);

        return view('admin.availability-slots.index', [
            'slots' => $slots,
            'currentDate' => $currentDate,
            'availableDays' => $availableDays,
            'pendingRequests' => $pendingRequests,
            'month' => $month,
            'year' => $year,
        ]);
    }

    public function calendar()
    {
        $month = request('month', now()->month);
        $year = request('year', now()->year);
        $currentDate = Carbon::createFromDate($year, $month, 1);

        // Récupérer les jours disponibles du mois
        $availableDays = AvailabilitySlot::where('slot_type', 'available')
            ->whereYear('available_date', $year)
            ->whereMonth('available_date', $month)
            ->pluck('available_date')
            ->map(fn($date) => $date->day)
            ->toArray();

        return view('admin.availability-slots.calendar', [
            'currentDate' => $currentDate,
            'availableDays' => $availableDays,
            'month' => $month,
            'year' => $year,
        ]);
    }

    public function toggleDay(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date_format:Y-m-d',
        ]);

        $date = Carbon::createFromFormat('Y-m-d', $validated['date'])->toDateString();

        // Vérifier si le jour existe déjà
        $slot = AvailabilitySlot::where('available_date', $date)
            ->where('slot_type', 'available')
            ->first();

        if ($slot) {
            // Supprimer le jour disponible
            $slot->delete();
            $message = 'Jour supprimé du calendrier.';
        } else {
            // Ajouter le jour comme disponible
            $availableDate = Carbon::parse($date);

            AvailabilitySlot::create([
                'available_date' => $date,
                'slot_type' => 'available',
                'start_time' => $availableDate->copy()->startOfDay(),
                'end_time' => $availableDate->copy()->endOfDay(),
                'is_available' => true,
            ]);
            $message = 'Jour ajouté au calendrier.';
        }

        if ($request->wantsJson()) {
            return response()->json(['message' => $message]);
        }

        return back()->with('status', $message);
    }

    public function pendingRequests()
    {
        $pendingAppointments = Appointment::pendingApproval()
            ->orderBy('appointment_date')
            ->orderBy('created_at')
            ->paginate(20);

        return view('admin.availability-slots.pending-requests', [
            'appointments' => $pendingAppointments,
        ]);
    }

    public function approveRequest(Appointment $appointment)
    {
        $appointment->update([
            'is_approved' => true,
            'status' => 'confirmed',
        ]);

        return back()->with('status', 'Demande approuvée. Le rendez-vous est confirmé.');
    }

    public function rejectRequest(Appointment $appointment)
    {
        $appointment->update(['status' => 'cancelled']);

        return back()->with('status', 'Demande rejetée.');
    }

    public function create()
    {
        return view('admin.availability-slots.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_time' => 'required|date_format:Y-m-d\TH:i|after_or_equal:now',
            'end_time' => 'required|date_format:Y-m-d\TH:i|after:start_time',
            'is_available' => 'nullable|boolean',
            'description' => 'nullable|string|max:500',
            'max_appointments' => 'required|integer|min:1',
        ]);

        $validated['start_time'] = str_replace('T', ' ', $validated['start_time']);
        $validated['end_time'] = str_replace('T', ' ', $validated['end_time']);
        $validated['is_available'] = $request->boolean('is_available');

        AvailabilitySlot::create($validated);

        return redirect()->route('admin.availability-slots.index')
            ->with('status', 'Créneau de disponibilité créé avec succès.');
    }

    public function edit(AvailabilitySlot $availabilitySlot)
    {
        return view('admin.availability-slots.edit', [
            'slot' => $availabilitySlot,
        ]);
    }

    public function update(Request $request, AvailabilitySlot $availabilitySlot)
    {
        $validated = $request->validate([
            'start_time' => 'required|date_format:Y-m-d\TH:i',
            'end_time' => 'required|date_format:Y-m-d\TH:i|after:start_time',
            'is_available' => 'nullable|boolean',
            'description' => 'nullable|string|max:500',
            'max_appointments' => 'required|integer|min:1',
        ]);

        $validated['start_time'] = str_replace('T', ' ', $validated['start_time']);
        $validated['end_time'] = str_replace('T', ' ', $validated['end_time']);
        $validated['is_available'] = $request->boolean('is_available');

        $availabilitySlot->update($validated);

        return redirect()->route('admin.availability-slots.index')
            ->with('status', 'Créneau de disponibilité mis à jour avec succès.');
    }

    public function destroy(AvailabilitySlot $availabilitySlot)
    {
        $availabilitySlot->delete();

        return redirect()->route('admin.availability-slots.index')
            ->with('status', 'Créneau de disponibilité supprimé avec succès.');
    }
}
