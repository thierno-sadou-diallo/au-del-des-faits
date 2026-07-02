<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        return Str::markdown($this->content ?? '', [
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

        // Essayer d'abord le chemin direct via le symlink public/storage
        $publicStoragePath = 'storage/' . $path;
        if (file_exists(public_path($publicStoragePath))) {
            return asset($publicStoragePath);
        }

        // Sinon, utiliser la route media-storage comme fallback
        return route('media.storage', ['path' => $path]);
    }
}
