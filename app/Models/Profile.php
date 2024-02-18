<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'avatar',
        'date_of_birth',
        'country',
        'city',
        'description',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasManyThrough
    {
        return $this->hasManyThrough(Comment::class, User::class);
    }

    public function hasAvatar(): bool
    {
        $defaultAvatarPath = 'assets/img/img-profile.png';

        if ($this->avatar !== $defaultAvatarPath) {
            return true;
        } else {
            return false;
        }

    }
}
