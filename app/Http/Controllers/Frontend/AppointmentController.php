<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AvailabilitySlot;
use App\Models\User;
use App\Notifications\AppointmentCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    public function index()
    {
        $slots = AvailabilitySlot::where('is_available', true)
            ->where('start_time', '>=', now())
            ->whereColumn('current_appointments', '<', 'max_appointments')
            ->orderBy('start_time')
            ->get();

        return view('frontend.appointment', [
            'slots' => $slots,
            'seoTitle' => 'Rendez-vous - Au-delà des faits',
            'seoDescription' => 'Prenez rendez-vous avec Halimatou Keita pour discuter de votre projet.',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'availability_slot_id' => 'required|exists:availability_slots,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'organization' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        try {
            $appointment = DB::transaction(function () use ($validated) {
                $slot = AvailabilitySlot::lockForUpdate()->findOrFail($validated['availability_slot_id']);

                if ($slot->start_time->isPast() || ! $slot->isAvailable()) {
                    throw new \RuntimeException('Ce créneau n\'est plus disponible.');
                }

                $appointment = Appointment::create([
                    ...$validated,
                    'tracking_token' => $this->makeTrackingToken(),
                ]);
                $slot->increment('current_appointments');

                return $appointment;
            });
        } catch (\RuntimeException $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['message' => $e->getMessage()], 422);
            }
            return back()->with('error', $e->getMessage())->withInput();
        }

        try {
            Notification::send(User::where('is_admin', true)->get(), new AppointmentCreated($appointment));
        } catch (\Throwable) {
            // La demande reste enregistrée même si l'envoi de notification échoue.
        }

        $message = 'Votre rendez-vous a été demandé avec succès. L\'équipe d\'Au-delà des faits reviendra vers vous rapidement.';

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'message' => $message,
                'appointment_id' => $appointment->id,
                'tracking_url' => route('appointment.status.show', $appointment->tracking_token),
                'redirect' => route('appointment.thankyou')
            ], 201);
        }

        return redirect()->route('appointment.thankyou')->with(['status' => $message, 'appointment_id' => $appointment->id]);
    }

    public function thankYou()
    {
        $appointment = null;
        if ($appointmentId = session('appointment_id')) {
            $appointment = Appointment::find($appointmentId);
        }

        return view('frontend.appointment-thankyou', [
            'appointment' => $appointment,
            'seoTitle' => 'Demande envoyee - Au-dela des faits',
            'seoDescription' => 'Votre demande de rendez-vous a ete enregistree.',
        ]);
    }

    public function statusForm()
    {
        return view('frontend.appointment-status', [
            'appointment' => null,
            'seoTitle' => 'Suivi de rendez-vous - Au-dela des faits',
            'seoDescription' => 'Consultez l evolution de votre demande de rendez-vous.',
        ]);
    }

    public function statusLookup(Request $request)
    {
        $validated = $request->validate([
            'tracking_token' => 'required|string|max:64',
            'email' => 'required|email|max:255',
        ]);

        $appointment = Appointment::where('tracking_token', $validated['tracking_token'])
            ->where('email', $validated['email'])
            ->first();

        if (! $appointment) {
            return back()
                ->withErrors(['tracking_token' => 'Aucune demande ne correspond a cette reference et cet email.'])
                ->withInput();
        }

        return redirect()->route('appointment.status.show', $appointment->tracking_token);
    }

    public function statusShow(Appointment $appointment)
    {
        return view('frontend.appointment-status', [
            'appointment' => $appointment->load('availabilitySlot'),
            'seoTitle' => 'Suivi de rendez-vous - Au-dela des faits',
            'seoDescription' => 'Consultez l evolution de votre demande de rendez-vous.',
        ]);
    }

    public function getSlots()
    {
        $slots = AvailabilitySlot::where('is_available', true)
            ->where('start_time', '>=', now())
            ->whereColumn('current_appointments', '<', 'max_appointments')
            ->orderBy('start_time')
            ->get()
            ->map(function ($slot) {
                return [
                    'id' => $slot->id,
                    'title' => $slot->start_time->format('H:i') . ' - ' . $slot->end_time->format('H:i'),
                    'start' => $slot->start_time->toIso8601String(),
                    'end' => $slot->end_time->toIso8601String(),
                    'description' => $slot->description,
                ];
            });

        return response()->json($slots);
    }

    private function makeTrackingToken(): string
    {
        do {
            $token = 'ADF-'.now()->format('Y').'-'.Str::upper(Str::random(10));
        } while (Appointment::where('tracking_token', $token)->exists());

        return $token;
    }
}
