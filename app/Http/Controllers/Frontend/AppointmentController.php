<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AvailabilitySlot;
use App\Models\User;
use App\Notifications\AppointmentCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    public function index()
    {
        $month = request('month', now()->month);
        $year = request('year', now()->year);
        $currentDate = Carbon::createFromDate($year, $month, 1);

        // Récupérer les jours disponibles du mois
        $availableDays = AvailabilitySlot::availableDays()
            ->whereYear('available_date', $year)
            ->whereMonth('available_date', $month)
            ->pluck('available_date')
            ->map(fn($date) => $date->day)
            ->toArray();

        // Récupérer aussi les anciens créneaux horaires si existants
        $slots = AvailabilitySlot::where('is_available', true)
            ->where('start_time', '>=', now())
            ->whereColumn('current_appointments', '<', 'max_appointments')
            ->orderBy('start_time')
            ->get();

        return view('frontend.appointment', [
            'slots' => $slots,
            'currentDate' => $currentDate,
            'availableDays' => $availableDays,
            'month' => $month,
            'year' => $year,
            'seoTitle' => 'Rendez-vous - Au-delà des faits',
            'seoDescription' => 'Prenez rendez-vous avec Halimatou Keita pour discuter de votre projet.',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_type' => 'required|in:available_day,request_day',
            'appointment_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'availability_slot_id' => 'nullable|exists:availability_slots,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'organization' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Si c'est un créneau disponible, vérifier qu'il existe
        if ($validated['appointment_type'] === 'available_day') {
            $availableDay = AvailabilitySlot::availableDays()
                ->where('available_date', $validated['appointment_date'])
                ->first();

            if (!$availableDay) {
                return back()->with('error', 'Ce jour n\'est pas disponible.')->withInput();
            }
        }

        try {
            $appointment = Appointment::create([
                'appointment_date' => $validated['appointment_date'],
                'availability_slot_id' => $validated['availability_slot_id'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'organization' => $validated['organization'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'tracking_token' => Str::random(64),
                'status' => 'pending',
                'is_approved' => $validated['appointment_type'] === 'available_day', // Auto-approuvé si jour disponible
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur s\'est produite lors de la création de votre rendez-vous.')->withInput();
        }

        try {
            Notification::send(User::where('is_admin', true)->get(), new AppointmentCreated($appointment));
        } catch (\Throwable) {
            // La demande reste enregistrée même si l'envoi de notification échoue.
        }

        if ($validated['appointment_type'] === 'available_day') {
            $message = 'Votre rendez-vous a été confirmé avec succès. L\'équipe d\'Au-delà des faits vous contactera pour confirmer l\'horaire.';
        } else {
            $message = 'Votre demande de rendez-vous a été envoyée. L\'équipe d\'Au-delà des faits examinera votre demande et vous contactera pour confirmation.';
        }

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
        return view('frontend.appointment-status-form', [
            'seoTitle' => 'Suivi de rendez-vous - Au-delà des faits',
            'seoDescription' => 'Suivez l\'état de votre demande de rendez-vous.',
        ]);
    }

    public function statusLookup(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $appointments = Appointment::where('email', $request->email)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($appointments->isEmpty()) {
            return back()->with('error', 'Aucun rendez-vous trouvé pour cet email.');
        }

        return view('frontend.appointment-status', [
            'appointments' => $appointments,
            'seoTitle' => 'Votre suivi - Au-delà des faits',
            'seoDescription' => 'Consultez l\'état de vos demandes de rendez-vous.',
        ]);
    }

    public function statusShow(string $token)
    {
        $appointment = Appointment::where('tracking_token', $token)->firstOrFail();

        return view('frontend.appointment-status-detail', [
            'appointment' => $appointment,
            'seoTitle' => 'Détail du rendez-vous - Au-delà des faits',
            'seoDescription' => 'Consultez les détails de votre rendez-vous.',
        ]);
    }

    private function makeTrackingToken(): string
    {
        do {
            $token = Str::random(64);
        } while (Appointment::where('tracking_token', $token)->exists());

        return $token;
    }
}
