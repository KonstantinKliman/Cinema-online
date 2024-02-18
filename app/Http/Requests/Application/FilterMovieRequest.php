<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterMovieRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'genres' => ['array', Rule::exists('genres', 'id'),],
            'min_rating' => ['nullable', 'numeric', 'min:0', 'max:5',],
            'max_rating' => ['nullable', 'numeric', 'min:0', 'max:5', 'gte:min_rating',],
        ];
    }
}
