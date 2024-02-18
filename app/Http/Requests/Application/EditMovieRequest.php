<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditMovieRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:1', 'max:255'],
            "country" => ['required', 'string'],
            "production_studio" => ['required', 'string'],
            "release_year" => ['required', 'integer'],
            'description' => ['required', 'string', 'min:1'],
            'genres' => ['required', Rule::exists('genres', 'id')],
            'movie_file_path' => ['mimetypes:video/mp4,video/mpeg,video/avi'],
            'poster_file_path' => ['image', 'max:4096'],
        ];
    }
}
