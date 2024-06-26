<?php

namespace App\Http\Requests\Dashboard;

use App\Enums\ReviewType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateReviewRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'movie_id' => ['required', Rule::exists('movies', 'id')],
            'type_id' => ['required', Rule::enum(ReviewType::class)],
            'title' => ['required', 'string', 'max:255'],
            'review' => ['required', 'string', 'max:65535'],
            'is_published' => ['required', 'boolean']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_published' => $this->toBoolean($this->is_published)
        ]);
    }

    private function toBoolean($booleable)
    {
        return filter_var($booleable, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
}
