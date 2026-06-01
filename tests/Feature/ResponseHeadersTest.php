<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResponseHeadersTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_can_use_shared_cache_headers(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $cacheControl = $response->headers->get('Cache-Control');

        $this->assertStringContainsString('public', $cacheControl);
        $this->assertStringContainsString('max-age=3600', $cacheControl);
        $this->assertStringContainsString('s-maxage=86400', $cacheControl);
    }

    public function test_authenticated_pages_are_not_publicly_cached(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/profile');

        $response->assertOk();
        $response->assertHeader('Cache-Control', 'no-store, private');
    }
}
