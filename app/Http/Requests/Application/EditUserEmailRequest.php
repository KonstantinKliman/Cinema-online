<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class EditUserEmailRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:users,email'],
        ];
    }
}
