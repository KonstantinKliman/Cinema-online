<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonRole extends Model
{
    use HasFactory;

    protected $table = 'person_roles';

    protected $fillable = [
        'name'
    ];

    public function moviePersonRole()
    {
        return $this->hasMany(MoviePersonRole::class);
    }
}
