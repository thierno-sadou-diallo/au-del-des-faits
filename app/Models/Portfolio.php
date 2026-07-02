<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'images',
        'technologies',
        'link',
        'video_url',
        'category_id',
        'views',
        'likes',
    ];

    protected $casts = [
        'images' => 'array',
        'technologies' => 'array',
        'views' => 'integer',
        'likes' => 'integer',
    ];

    protected $appends = [
        'description_html',
        'excerpt',
        'cover_image_url',
        'image_urls',
    ];

    public function getCoverImageUrlAttribute(): ?string
    {
        return $this->storedImageUrl($this->images[0] ?? null);
    }

    public function getImageUrlsAttribute(): array
    {
        return collect($this->images ?? [])
            ->map(fn ($image) => $this->storedImageUrl($image))
            ->filter()
            ->values()
            ->all();
    }

    public function getExcerptAttribute(): string
    {
        return Str::of(Str::markdown($this->description ?? '', ['html_input' => 'strip']))
            ->stripTags()
            ->squish()
            ->limit(160)
            ->toString();
    }

    public function getDescriptionHtmlAttribute(): string
    {
        return Str::markdown($this->description ?? '', [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    private function storedImageUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        $path = ltrim($path, '/');

        if (Str::startsWith($path, ['http://', 'https://', '//'])) {
            return $path;
        }

        if (Str::startsWith($path, 'storage/')) {
            $path = Str::after($path, 'storage/');
        }

        if (Str::startsWith($path, 'public/')) {
            $path = Str::after($path, 'public/');
        }

        return url('media-storage/'.$path);
    }
}
