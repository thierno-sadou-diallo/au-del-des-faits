<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPostImagePersistenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_uploaded_article_image_is_visible_on_public_site(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['is_admin' => true]);
        $image = UploadedFile::fake()->image('article-public.jpg', 1200, 675);

        $this->actingAs($admin)->post(route('admin.posts.store'), [
            'title' => 'Article avec image admin',
            'content' => 'Contenu public de l article.',
            'status' => 'published',
            'image' => $image,
        ])->assertRedirect(route('admin.posts.index'));

        $post = Post::firstOrFail();

        $this->assertNotNull($post->image);
        Storage::disk('public')->assertExists($post->image);

        $this->get(route('blog.index'))
            ->assertOk()
            ->assertSee($post->image_url, false);

        $this->get(route('blog.show', $post->slug))
            ->assertOk()
            ->assertSee($post->image_url, false);

        $this->get($post->image_url)->assertOk();
    }

    public function test_article_image_survives_admin_update_without_new_image(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['is_admin' => true]);
        Storage::disk('public')->put('posts/kept-image.jpg', 'image-content');

        $post = Post::create([
            'title' => 'Titre original',
            'slug' => 'titre-original',
            'content' => 'Ancien contenu',
            'status' => 'published',
            'image' => 'posts/kept-image.jpg',
        ]);

        $this->actingAs($admin)->patch(route('admin.posts.update', $post), [
            'title' => 'Titre modifie',
            'content' => 'Contenu modifie',
            'status' => 'published',
        ])->assertRedirect(route('admin.posts.index'));

        $post->refresh();

        $this->assertSame('posts/kept-image.jpg', $post->image);
        Storage::disk('public')->assertExists('posts/kept-image.jpg');

        $this->get(route('blog.show', $post->slug))
            ->assertOk()
            ->assertSee($post->image_url, false);
    }

    public function test_admin_can_explicitly_remove_article_image(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['is_admin' => true]);
        Storage::disk('public')->put('posts/remove-me.jpg', 'image-content');

        $post = Post::create([
            'title' => 'Article a nettoyer',
            'slug' => 'article-a-nettoyer',
            'content' => 'Contenu',
            'status' => 'published',
            'image' => 'posts/remove-me.jpg',
        ]);

        $this->actingAs($admin)->patch(route('admin.posts.update', $post), [
            'title' => 'Article a nettoyer',
            'content' => 'Contenu',
            'status' => 'published',
            'remove_image' => '1',
        ])->assertRedirect(route('admin.posts.index'));

        $post->refresh();

        $this->assertNull($post->image);
        Storage::disk('public')->assertMissing('posts/remove-me.jpg');
    }
}
