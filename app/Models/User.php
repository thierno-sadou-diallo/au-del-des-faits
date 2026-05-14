<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getBadgeAttribute()
    {
        if ($this->badge_level === 'curator') {
            return ['class' => 'curator', 'label' => 'Curateur'];
        } elseif ($this->badge_level === 'super-fan') {
            return ['class' => 'super-fan', 'label' => 'Super Fan'];
        } elseif ($this->badge_level === 'contributor') {
            return ['class' => 'contributor', 'label' => 'Contributeur'];
        }
        return null;
    }

    public function updateEngagementScore()
    {
        $score = $this->comments()->count() * 5; // 5 points par commentaire approuvé
        $this->engagement_score = $score;

        // Auto-update badge level
        if ($score >= 100) {
            $this->badge_level = 'curator';
        } elseif ($score >= 50) {
            $this->badge_level = 'super-fan';
        } elseif ($score >= 20) {
            $this->badge_level = 'contributor';
        } else {
            $this->badge_level = 'none';
        }

        $this->save();
    }
}
