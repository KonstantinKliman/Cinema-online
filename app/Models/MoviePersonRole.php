<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoviePersonRole extends Model
{
    use HasFactory;

    protected $table = 'movie_person_role';

    protected $fillable = [
        'movie_id',
        'person_id',
        'role_id'
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class,'movie_id');
    }

    public function person()
    {
        return $this->belongsTo(Person::class,'person_id');
    }

    public function role()
    {
        return $this->belongsTo(PersonRole::class, 'role_id');
    }
}
