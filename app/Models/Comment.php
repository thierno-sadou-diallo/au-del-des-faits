<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'commentable_type',
        'commentable_id',
        'name',
        'email',
        'message',
        'parent_id',
        'is_approved',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    // Accessor to get the actual commentable (post or portfolio)
    public function getCommentableAttribute()
    {
        if ($this->commentable_type && $this->commentable_id) {
            return $this->morphTo();
        }
        return $this->post;
    }
}

