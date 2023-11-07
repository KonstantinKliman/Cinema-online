<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class UploadMovieRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:1', 'max:255'],
            'description' => ['required', 'string', 'min:1'],
            'movie_file_path' => ['required', 'mimetypes:video/mp4,video/mpeg,video/avi'],
            'poster_file_path' => ['required', 'image', 'max:4096'],
        ];
    }
}
