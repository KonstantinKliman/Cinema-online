<?php

namespace App\Http\Requests\Application\User;

use App\Enums\RoleType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'min:3', 'unique:users,name'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role' => [Rule::enum(RoleType::class)],
        ];
    }
}
