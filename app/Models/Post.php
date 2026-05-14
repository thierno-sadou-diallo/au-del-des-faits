<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
