<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
