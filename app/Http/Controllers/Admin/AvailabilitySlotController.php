<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AvailabilitySlot;
use Illuminate\Http\Request;

class AvailabilitySlotController extends Controller
{
    public function index()
    {
        $slots = AvailabilitySlot::orderBy('start_time', 'desc')->paginate(20);

        return view('admin.availability-slots.index', [
            'slots' => $slots,
        ]);
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
