<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterMovieRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'min_year' => ['nullable', 'numeric', 'min:1895', 'max:' . now()->year],
            'max_year' => ['nullable', 'numeric', 'min:1895', 'max:' . now()->year, 'gte:min_year'],
            'genres' => ['array', Rule::exists('genres', 'id'),],
            'min_rating' => ['nullable', 'numeric', 'min:0', 'max:5',],
            'max_rating' => ['nullable', 'numeric', 'min:0', 'max:5', 'gte:min_rating'],
            'country' => ['array', Rule::exists('movies', 'country')],
            'production_studio' => ['array', Rule::exists('movies', 'production_studio')]
        ];
    }
}
