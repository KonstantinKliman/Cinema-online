<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class EditProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'last_name' => ['string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'date_of_birth' => ['nullable', 'date'],
            'country' => ['nullable', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'city' => ['nullable', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'description' => ['nullable', 'string'],
        ];
    }
}
