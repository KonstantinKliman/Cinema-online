<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttachMovieToPersonRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'movie_id' => [Rule::exists('movies', 'id')],
            'person_id' => [Rule::exists('persons', 'id')],
            'role_id' => [Rule::exists('person_roles', 'id')],
        ];
    }
}
