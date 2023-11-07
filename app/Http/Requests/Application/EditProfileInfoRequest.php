<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class EditProfileInfoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'last_name' => ['string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'date_of_birth' => ['date'],
            'country' => ['string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'city' => ['string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'description' => ['string'],
        ];
    }
}
