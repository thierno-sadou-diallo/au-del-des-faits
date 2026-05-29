<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceReview extends Model
{
    protected $fillable = [
        'name',
        'email',
        'organization',
        'rating',
        'message',
        'admin_reply',
        'admin_reply_author',
        'replied_at',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'replied_at' => 'datetime',
    ];
}
