<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class EditUserCityRequest extends FormRequest
{
    function rules(): array
    {
        return [
            'city' => ['string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
        ];
    }
}
