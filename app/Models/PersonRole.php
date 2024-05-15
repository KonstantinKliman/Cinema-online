<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PersonRole extends Model
{
    use HasFactory;

    protected $table = 'person_roles';

    protected $fillable = [
        'name'
    ];

    public function moviePersonRole(): HasMany
    {
        return $this->hasMany(MoviePersonRole::class);
    }
}
