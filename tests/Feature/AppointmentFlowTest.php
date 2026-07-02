<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\AvailabilitySlot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class AppointmentFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_can_request_a_date_when_admin_has_no_active_dates(): void
    {
        $date = now()->addDays(5)->toDateString();

        $this->post(route('appointment.store'), $this->payload([
            'appointment_type' => 'request_day',
            'appointment_date' => $date,
        ]))->assertRedirect(route('appointment.thankyou'));

        $appointment = Appointment::first();

        $this->assertNotNull($appointment);
        $this->assertSame($date, $appointment->appointment_date->toDateString());
        $this->assertSame('pending', $appointment->status);
        $this->assertFalse($appointment->is_approved);
        $this->assertSame('request', $appointment->availabilitySlot->slot_type);
    }

    public function test_visitor_must_choose_admin_date_when_one_exists(): void
    {
        $slot = $this->availableSlot(now()->addDays(3));
        $requestedDate = now()->addDays(7)->toDateString();

        $this->from(route('appointment'))->post(route('appointment.store'), $this->payload([
            'appointment_type' => 'request_day',
            'appointment_date' => $requestedDate,
        ]))->assertRedirect(route('appointment'));

        $this->assertDatabaseCount('appointments', 0);
        $this->assertSame(0, $slot->fresh()->current_appointments);
    }

    public function test_admin_active_date_is_confirmed_immediately(): void
    {
        $date = now()->addDays(4);
        $slot = $this->availableSlot($date, maxAppointments: 2);

        $this->post(route('appointment.store'), $this->payload([
            'appointment_type' => 'available_day',
            'appointment_date' => $date->toDateString(),
            'availability_slot_id' => $slot->id,
        ]))->assertSessionHasNoErrors()
            ->assertRedirect(route('appointment.thankyou'));

        $appointment = Appointment::first();

        $this->assertSame($slot->id, $appointment->availability_slot_id);
        $this->assertSame('confirmed', $appointment->status);
        $this->assertTrue($appointment->is_approved);
        $this->assertSame(1, $slot->fresh()->current_appointments);
    }

    public function test_admin_capacity_cannot_be_exceeded(): void
    {
        $date = now()->addDays(6);
        $slot = $this->availableSlot($date, maxAppointments: 1, currentAppointments: 1);

        $this->from(route('appointment'))->post(route('appointment.store'), $this->payload([
            'appointment_type' => 'available_day',
            'appointment_date' => $date->toDateString(),
            'availability_slot_id' => $slot->id,
        ]))->assertRedirect(route('appointment'));

        $this->assertDatabaseCount('appointments', 0);
        $this->assertSame(1, $slot->fresh()->current_appointments);
    }

    public function test_visitor_can_request_a_date_when_all_admin_slots_are_full(): void
    {
        $adminDate = now()->addDays(2);
        $requestedDate = now()->addDays(8)->toDateString();

        $this->availableSlot($adminDate, maxAppointments: 1, currentAppointments: 1);

        $this->post(route('appointment.store'), $this->payload([
            'appointment_type' => 'request_day',
            'appointment_date' => $requestedDate,
        ]))->assertRedirect(route('appointment.thankyou'));

        $appointment = Appointment::first();

        $this->assertSame($requestedDate, $appointment->appointment_date->toDateString());
        $this->assertSame('pending', $appointment->status);
        $this->assertFalse($appointment->is_approved);
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'appointment_type' => 'request_day',
            'appointment_date' => Carbon::tomorrow()->toDateString(),
            'name' => 'Awa Diop',
            'email' => 'awa@example.com',
            'phone' => '770000000',
            'organization' => 'Media Test',
            'subject' => 'Entretien',
            'message' => 'Je souhaite prendre rendez-vous pour discuter du projet.',
        ], $overrides);
    }

    private function availableSlot(Carbon $date, int $maxAppointments = 1, int $currentAppointments = 0): AvailabilitySlot
    {
        return AvailabilitySlot::create([
            'available_date' => $date->toDateString(),
            'slot_type' => 'available',
            'start_time' => $date->copy()->startOfDay(),
            'end_time' => $date->copy()->endOfDay(),
            'is_available' => true,
            'max_appointments' => $maxAppointments,
            'current_appointments' => $currentAppointments,
        ]);
    }
}
