<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SortMovieRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'sort' => ['string', Rule::in(['desc', 'asc', 'newest_upload', 'oldest_upload', 'best_rating', 'worst_rating', 'newest_release_year', 'oldest_release_year'])]
        ];
    }
}
