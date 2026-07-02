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
        $bookableSlots = $this->bookableSlotsQuery()
            ->orderBy('available_date')
            ->orderBy('start_time')
            ->get();

        $availableDates = $bookableSlots
            ->map(fn ($slot) => Carbon::parse($slot->available_date)->toDateString())
            ->unique()
            ->values();

        $availableDays = $availableDates
            ->map(fn ($date) => Carbon::parse($date))
            ->filter(fn ($date) => $date->year === (int) $year && $date->month === (int) $month)
            ->map(fn ($date) => $date->day)
            ->values()
            ->toArray();

        $availableSlotMap = $bookableSlots
            ->groupBy(fn ($slot) => Carbon::parse($slot->available_date)->toDateString())
            ->map(fn ($slots) => $slots->map(fn ($slot) => [
                'id' => $slot->id,
                'remaining' => max($slot->max_appointments - $slot->current_appointments, 0),
                'capacity' => $slot->max_appointments,
                'label' => $slot->start_time->isSameDay($slot->end_time)
                    ? $slot->start_time->format('H:i').' - '.$slot->end_time->format('H:i')
                    : 'Journee',
            ])->values())
            ->toArray();

        $hasBookableSlots = $bookableSlots->isNotEmpty();

        return view('frontend.appointment', [
            'slots' => $bookableSlots,
            'currentDate' => $currentDate,
            'availableDays' => $availableDays,
            'availableDates' => $availableDates,
            'availableSlotMap' => $availableSlotMap,
            'hasAdminAvailableDates' => $hasBookableSlots,
            'hasBookableSlots' => $hasBookableSlots,
            'month' => $month,
            'year' => $year,
            'seoTitle' => 'Rendez-vous - Au-dela des faits',
            'seoDescription' => 'Prenez rendez-vous avec Halimatou Keita pour discuter de votre projet.',
        ]);
    }

    public function getSlots(Request $request)
    {
        $validated = $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:'.now()->year.'|max:'.now()->addYears(3)->year,
        ]);

        $availableDates = $this->bookableSlotsQuery()
            ->whereYear('available_date', $validated['year'])
            ->whereMonth('available_date', $validated['month'])
            ->orderBy('available_date')
            ->pluck('available_date')
            ->map(fn ($date) => Carbon::parse($date)->toDateString())
            ->unique()
            ->values();

        return response()->json([
            'available_dates' => $availableDates,
            'has_admin_available_dates' => $this->bookableSlotsQuery()->exists(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_type' => 'required|in:available_day,request_day',
            'appointment_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'availability_slot_id' => 'required_if:appointment_type,available_day|nullable|exists:availability_slots,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'organization' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        try {
            $appointment = DB::transaction(function () use ($validated) {
                if ($validated['appointment_type'] === 'available_day') {
                    $slot = AvailabilitySlot::lockForUpdate()->findOrFail($validated['availability_slot_id']);
                    $slotDate = Carbon::parse($slot->available_date)->toDateString();

                    if (
                        $slot->slot_type !== 'available'
                        || ! $slot->is_available
                        || $slotDate !== $validated['appointment_date']
                        || Carbon::parse($slotDate)->lt(now()->startOfDay())
                        || $slot->current_appointments >= $slot->max_appointments
                    ) {
                        throw new \RuntimeException('Ce creneau n est plus disponible.');
                    }

                    $appointment = $this->createAppointment($validated, $slot, true);
                    $slot->increment('current_appointments');

                    return $appointment;
                }

                $requestedDate = Carbon::createFromFormat('Y-m-d', $validated['appointment_date']);
                $requestSlot = AvailabilitySlot::create([
                    'available_date' => $requestedDate->toDateString(),
                    'slot_type' => 'request',
                    'start_time' => $requestedDate->copy()->startOfDay(),
                    'end_time' => $requestedDate->copy()->endOfDay(),
                    'is_available' => false,
                    'max_appointments' => 1,
                    'current_appointments' => 0,
                ]);

                return $this->createAppointment($validated, $requestSlot, false);
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage())->withInput();
        } catch (\Exception $e) {
            report($e);

            if (app()->environment('testing')) {
                throw $e;
            }

            return back()->with('error', 'Une erreur s est produite lors de la creation de votre rendez-vous.')->withInput();
        }

        try {
            Notification::send(User::where('is_admin', true)->get(), new AppointmentCreated($appointment));
        } catch (\Throwable) {
            // La demande reste enregistree meme si l envoi de notification echoue.
        }

        $message = $appointment->is_approved
            ? 'Votre rendez-vous a ete confirme avec succes.'
            : 'Votre demande de rendez-vous a ete envoyee. L admin examinera votre demande.';

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'message' => $message,
                'appointment_id' => $appointment->id,
                'tracking_url' => route('appointment.status.show', $appointment->tracking_token),
                'redirect' => route('appointment.thankyou'),
            ], 201);
        }

        return redirect()->route('appointment.thankyou')->with([
            'status' => $message,
            'appointment_id' => $appointment->id,
        ]);
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
            'seoTitle' => 'Suivi de rendez-vous - Au-dela des faits',
            'seoDescription' => 'Suivez l etat de votre demande de rendez-vous.',
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
            return back()->with('error', 'Aucun rendez-vous trouve pour cet email.');
        }

        return view('frontend.appointment-status', [
            'appointments' => $appointments,
            'seoTitle' => 'Votre suivi - Au-dela des faits',
            'seoDescription' => 'Consultez l etat de vos demandes de rendez-vous.',
        ]);
    }

    public function statusShow(string $token)
    {
        $appointment = Appointment::where('tracking_token', $token)->firstOrFail();

        return view('frontend.appointment-status-detail', [
            'appointment' => $appointment,
            'seoTitle' => 'Detail du rendez-vous - Au-dela des faits',
            'seoDescription' => 'Consultez les details de votre rendez-vous.',
        ]);
    }

    private function bookableSlotsQuery()
    {
        return AvailabilitySlot::query()
            ->where('slot_type', 'available')
            ->where('is_available', true)
            ->whereDate('available_date', '>=', now()->toDateString())
            ->whereColumn('current_appointments', '<', 'max_appointments');
    }

    private function createAppointment(array $validated, AvailabilitySlot $slot, bool $isApproved): Appointment
    {
        return Appointment::create([
            'appointment_date' => $validated['appointment_date'],
            'availability_slot_id' => $slot->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'organization' => $validated['organization'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'tracking_token' => Str::random(64),
            'status' => $isApproved ? 'confirmed' : 'pending',
            'is_approved' => $isApproved,
        ]);
    }
}
