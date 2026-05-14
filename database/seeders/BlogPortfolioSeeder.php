<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Portfolio;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPortfolioSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@blogportfolio.local'],
            [
                'name' => 'Admin',
                'password' => 'password',
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        $blogCategory = Category::updateOrCreate(
            ['name' => 'Laravel'],
            ['type' => 'blog']
        );
        $portfolioCategory = Category::updateOrCreate(
            ['name' => 'Applications Web'],
            ['type' => 'portfolio']
        );
        $mediaCategory = Category::updateOrCreate(
            ['name' => 'Interventions publiques'],
            ['type' => 'media']
        );

        foreach ([
            'Bien demarrer avec Laravel 12',
            'SEO technique pour applications Laravel',
            'Optimiser les performances Eloquent',
        ] as $title) {
            Post::updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title' => $title,
                    'content' => '<p>Contenu de demonstration pour le blog.</p>',
                    'status' => 'published',
                    'category_id' => $blogCategory->id,
                ]
            );
        }

        Portfolio::updateOrCreate(
            ['slug' => 'plateforme-blog-portfolio'],
            [
                'title' => 'Plateforme Blog Portfolio',
                'description' => 'Projet Laravel complet avec administration et SEO.',
                'images' => [],
                'technologies' => ['Laravel', 'MySQL', 'Blade'],
                'link' => 'https://example.com',
                'category_id' => $portfolioCategory->id,
            ]
        );

        Portfolio::updateOrCreate(
            ['slug' => 'interview-sociologie-et-medias'],
            [
                'title' => 'Interview sociologie et medias',
                'description' => 'Exemple de media publie depuis l administration.',
                'images' => [],
                'technologies' => ['Interview', 'Media', 'Sociologie'],
                'link' => null,
                'video_url' => 'https://example.com',
                'category_id' => $mediaCategory->id,
            ]
        );
    }
}
