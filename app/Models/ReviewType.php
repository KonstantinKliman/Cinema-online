<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReviewType extends Model
{
    use HasFactory;

    protected $table = 'review_types';

    protected $fillable = [
        'name'
    ];

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'type_id');
    }
}
