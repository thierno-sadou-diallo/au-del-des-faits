<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'status',
        'category_id',
        'views',
        'likes',
    ];

    protected $casts = [
        'views' => 'integer',
        'likes' => 'integer',
    ];

    protected $appends = [
        'content_html',
        'excerpt',
        'image_url',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return $this->storedImageUrl($this->image);
    }

    public function getExcerptAttribute(): string
    {
        return Str::of(Str::markdown($this->content ?? '', ['html_input' => 'strip']))
            ->stripTags()
            ->squish()
            ->limit(180)
            ->toString();
    }

    public function getContentHtmlAttribute(): string
    {
        return $this->renderPublicContent($this->content);
    }

    private function renderPublicContent(?string $content): string
    {
        $content = trim($content ?? '');

        if ($content === '') {
            return '';
        }

        if ($this->containsHtml($content)) {
            $content = preg_replace('/<(script|style)\b[^>]*>.*?<\/\1>/is', '', $content) ?? $content;

            return trim(strip_tags($content, '<p><br><strong><b><em><i><u><ul><ol><li><blockquote><h1><h2><h3><h4><h5><h6><a><img>'));
        }

        $html = Str::markdown($content, [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        if (blank(strip_tags($html))) {
            return nl2br(e(strip_tags($content)));
        }

        return $html;
    }

    private function containsHtml(string $content): bool
    {
        return $content !== strip_tags($content);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function morphedComments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    private function storedImageUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        $path = ltrim($path, '/');

        // Si c'est une URL absolue, la retourner directement
        if (Str::startsWith($path, ['http://', 'https://', '//'])) {
            return $path;
        }

        // Nettoyer le chemin des préfixes storage/ et public/
        if (Str::startsWith($path, 'storage/')) {
            $path = Str::after($path, 'storage/');
        }
        if (Str::startsWith($path, 'public/')) {
            $path = Str::after($path, 'public/');
        }

        $disk = config('filesystems.media_disk', 'public');

        if (config("filesystems.disks.{$disk}.driver") === 'local') {
            // En local, cette route evite les problemes de symlink public/storage.
            return route('media.storage', ['path' => $path]);
        }

        return Storage::disk($disk)->url($path);
    }
}
