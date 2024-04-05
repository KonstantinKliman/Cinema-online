<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'movie_file_path',
        'poster_file_path',
        'rating',
        'country',
        'release_year',
        'production_studio',
    ];

    protected static function booted()
    {
        static::deleted(function ($movie) {
            Storage::delete([
                str_replace('storage/', '', $movie->movie_file_path),
                str_replace('storage/', '', $movie->poster_file_path)
            ]);
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function persons(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'movie_person_role', 'movie_id', 'person_id')
                    ->withPivot('role_id');
    }

    public function personRoles()
    {
        return $this->hasMany(MoviePersonRole::class, 'movie_id');
    }
}
