<?php

namespace Tests\Feature;

use App\Models\NewsletterSubscriber;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminNewsletterSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_newsletter_sort_parameters_are_whitelisted(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        NewsletterSubscriber::create(['email' => 'awa@example.com']);

        $this->actingAs($admin)
            ->get(route('admin.newsletter-subscribers.index', [
                'sort' => 'email desc, id',
                'order' => 'sideways',
            ]))
            ->assertOk()
            ->assertSee('awa@example.com');
    }
}
