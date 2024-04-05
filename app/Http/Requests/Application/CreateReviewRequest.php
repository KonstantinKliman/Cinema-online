<?php

namespace App\Http\Requests\Application;

use App\Enums\ReviewType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateReviewRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => ['required', Rule::enum(ReviewType::class)],
            'title' => ['required', 'string', 'max:255'],
            'review' => ['required', 'string', 'max:65535'],
        ];
    }
}
