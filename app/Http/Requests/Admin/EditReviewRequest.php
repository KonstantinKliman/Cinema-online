<?php

namespace App\Http\Requests\Admin;

use App\Enums\ReviewType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditReviewRequest extends FormRequest
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
