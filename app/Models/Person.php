<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Person extends Model
{
    use HasFactory;

    protected $table = 'persons';

    protected $fillable = [
        'full_name',
        'slug',
    ];

    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'movie_person_role', 'person_id', 'movie_id')
                    ->withPivot('role_id');
    }

    public function movieRoles()
    {
        return $this->hasMany(MoviePersonRole::class, 'person_id');
    }
}
