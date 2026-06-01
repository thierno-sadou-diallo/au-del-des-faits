<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('publicPageProvider')]
    public function test_public_pages_render_successfully(string $path): void
    {
        $this->get($path)->assertOk();
    }

    public static function publicPageProvider(): array
    {
        return [
            'home' => ['/'],
            'about' => ['/a-propos'],
            'topics' => ['/thematiques'],
            'media' => ['/medias'],
            'services' => ['/services'],
            'contact' => ['/contact'],
            'appointment' => ['/rendez-vous'],
            'blog' => ['/blog'],
            'portfolio' => ['/portfolio'],
            'robots' => ['/robots.txt'],
            'sitemap' => ['/sitemap.xml'],
        ];
    }
}
