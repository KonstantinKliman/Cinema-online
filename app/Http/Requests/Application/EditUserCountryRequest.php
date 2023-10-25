<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class EditUserCountryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'country' => ['string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
        ];
    }
}
