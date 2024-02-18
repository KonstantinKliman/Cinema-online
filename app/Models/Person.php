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
        'person_url',
    ];

    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class)->withPivot('role');
    }

}
