<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Portfolio;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicContentRenderingTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_article_detail_displays_admin_text(): void
    {
        $category = Category::create([
            'name' => 'Analyses',
            'type' => 'blog',
        ]);

        $post = Post::create([
            'title' => 'Article public',
            'slug' => 'article-public',
            'content' => '<p>Texte publie par admin visible par les visiteurs.</p>',
            'status' => 'published',
            'category_id' => $category->id,
        ]);

        $this->get(route('blog.show', $post->slug))
            ->assertOk()
            ->assertHeader('Cache-Control', 'no-store, private')
            ->assertSee('Article public')
            ->assertSee('Texte publie par admin visible par les visiteurs.', false)
            ->assertSee('Partager')
            ->assertSee("J'aime", false)
            ->assertSee('Copier le lien')
            ->assertSee('Laisser un commentaire')
            ->assertSee('captcha-wrapper', false)
            ->assertDontSee('Lecture vocale')
            ->assertDontSee('Traduction')
            ->assertDontSee('Chargement du captcha...')
            ->assertDontSee('articleVoiceIntro', false)
            ->assertSee('.article-layout[data-reveal]', false)
            ->assertSee("!element.closest('.article-layout')", false);
    }

    public function test_media_page_displays_uploaded_images_and_detail_page(): void
    {
        $imageDirectory = storage_path('app/public/portfolio');
        if (! is_dir($imageDirectory)) {
            mkdir($imageDirectory, 0777, true);
        }
        file_put_contents($imageDirectory.'/media-test.jpg', 'fake image content');

        try {
            $portfolio = Portfolio::create([
                'title' => 'Media public',
                'slug' => 'media-public',
                'description' => '<p>Description publiee par admin.</p>',
                'images' => ['portfolio/media-test.jpg'],
                'technologies' => ['Terrain'],
            ]);
            $imageUrl = $portfolio->fresh()->cover_image_url;

            $this->assertStringContainsString('/media-storage/portfolio/media-test.jpg', $imageUrl);

            $this->get(route('medias'))
                ->assertOk()
                ->assertSee('Media public')
                ->assertSee(route('medias.show', $portfolio->slug), false)
                ->assertSee($imageUrl, false);

            $this->get(route('medias.show', $portfolio->slug))
                ->assertOk()
                ->assertSee('Description publiee par admin.', false)
                ->assertSee($imageUrl, false);

            $this->get(route('media.storage', ['path' => 'portfolio/media-test.jpg']))
                ->assertOk();
        } finally {
            @unlink($imageDirectory.'/media-test.jpg');
        }
    }

    public function test_blog_image_urls_use_dedicated_media_storage_route(): void
    {
        $post = new Post([
            'title' => 'Article avec image',
            'slug' => 'article-avec-image',
            'content' => 'Contenu',
            'status' => 'published',
            'image' => 'posts/article-test.jpg',
        ]);

        $this->assertStringContainsString('/media-storage/posts/article-test.jpg', $post->image_url);
    }
}
