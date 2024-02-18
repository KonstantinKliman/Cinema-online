<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePersonRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'fullName' => ['required', 'string', 'min:10', 'max:50'],
            'role' => ['required', 'string', Rule::in(['director', 'producer', 'actor', 'screenwriter', 'cameraman', 'composer'])],
        ];
    }
}
