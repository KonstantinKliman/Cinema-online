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

    public function personRoles(): HasMany
    {
        return $this->hasMany(MoviePersonRole::class, 'movie_id');
    }

    public function getPersons(): array
    {
        $personsByRole = [];

        // Получаем все роли и их исполнителей для данного фильма
        $roles = $this->personRoles()->with('role', 'person')->get();


        foreach ($roles as $role) {
            $roleName = $role->role->name;
            $person = $role->person;

            // Если роль уже существует в массиве, добавляем исполнителя в массив исполнителей этой роли
            if (array_key_exists($roleName, $personsByRole)) {
                // Проверяем, является ли исполнитель массивом
                if (is_array($personsByRole[$roleName])) {
                    // Добавляем исполнителя в массив исполнителей этой роли
                    $personsByRole[$roleName][] = $person;
                } else {
                    // Преобразуем одиночного исполнителя в массив
                    $personsByRole[$roleName] = [$personsByRole[$roleName], $person];
                }
            } else {
                // Создаем новую запись для роли и исполнителя
                $personsByRole[$roleName] = $person;
            }
        }

        return $personsByRole;
    }

}
