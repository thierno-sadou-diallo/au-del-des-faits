<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\AvailabilitySlot;
use App\Models\Post;
use App\Models\ServiceReview;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_reviews_are_moderated_by_default(): void
    {
        $this->post(route('services.reviews.store'), [
            'name' => 'Awa Diop',
            'organization' => 'Media Test',
            'rating' => 5,
            'message' => 'Un accompagnement tres utile et professionnel.',
        ])->assertRedirect();

        $review = ServiceReview::first();

        $this->assertNotNull($review);
        $this->assertFalse($review->is_approved);
    }

    public function test_appointment_status_lookup_requires_token_and_email_pair(): void
    {
        $date = now()->addDays(3);
        $slot = AvailabilitySlot::create([
            'available_date' => $date->toDateString(),
            'slot_type' => 'request',
            'start_time' => $date->copy()->startOfDay(),
            'end_time' => $date->copy()->endOfDay(),
            'is_available' => false,
            'max_appointments' => 1,
            'current_appointments' => 0,
        ]);

        $appointment = Appointment::create([
            'availability_slot_id' => $slot->id,
            'appointment_date' => $date->toDateString(),
            'name' => 'Awa Diop',
            'email' => 'awa@example.com',
            'subject' => 'Entretien',
            'message' => 'Demande de rendez-vous.',
            'status' => 'pending',
            'is_approved' => false,
            'tracking_token' => 'secret-token',
        ]);

        $this->post(route('appointment.status.lookup'), [
            'tracking_token' => 'wrong-token',
            'email' => 'awa@example.com',
        ])->assertSessionHasErrors('tracking_token');

        $this->post(route('appointment.status.lookup'), [
            'tracking_token' => $appointment->tracking_token,
            'email' => 'awa@example.com',
        ])->assertOk()
            ->assertSee($appointment->tracking_token);
    }

    public function test_appointment_status_link_does_not_reveal_details_without_email(): void
    {
        $date = now()->addDays(3);
        $slot = AvailabilitySlot::create([
            'available_date' => $date->toDateString(),
            'slot_type' => 'request',
            'start_time' => $date->copy()->startOfDay(),
            'end_time' => $date->copy()->endOfDay(),
            'is_available' => false,
            'max_appointments' => 1,
            'current_appointments' => 0,
        ]);

        $appointment = Appointment::create([
            'availability_slot_id' => $slot->id,
            'appointment_date' => $date->toDateString(),
            'name' => 'Awa Diop',
            'email' => 'awa@example.com',
            'subject' => 'Sujet prive',
            'message' => 'Demande de rendez-vous.',
            'status' => 'pending',
            'is_approved' => false,
            'tracking_token' => 'secret-token',
        ]);

        $this->get(route('appointment.status.show', $appointment->tracking_token))
            ->assertOk()
            ->assertSee($appointment->tracking_token)
            ->assertDontSee('Sujet prive');
    }

    public function test_post_like_is_counted_once_per_session(): void
    {
        $post = Post::create([
            'title' => 'Article public',
            'slug' => 'article-public',
            'content' => 'Contenu',
            'status' => 'published',
            'likes' => 0,
        ]);

        $this->post(route('blog.like', $post))->assertRedirect();
        $this->post(route('blog.like', $post))->assertRedirect();

        $this->assertSame(1, $post->fresh()->likes);
    }
}
