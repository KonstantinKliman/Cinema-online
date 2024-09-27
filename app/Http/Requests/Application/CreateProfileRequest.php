<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', Rule::exists('users', 'id')],
            'first_name' => ['nullable', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'last_name' => ['nullable', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'date_of_birth' => ['nullable', 'date'],
            'country' => ['nullable', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'city' => ['nullable', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'description' => ['nullable', 'string'],
            'profile_photo' => ['dimensions:min_width=500,min_height=500', 'dimensions:max_width=500,max_height=500', 'image', 'max:2048'],
        ];
    }
}
