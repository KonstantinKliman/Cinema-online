<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class CreateRatingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'rating' => ['required', 'numeric', 'min:1', 'max:5']
        ];
    }
}
