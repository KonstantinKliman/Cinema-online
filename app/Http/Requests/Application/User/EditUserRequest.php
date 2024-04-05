<?php

namespace App\Http\Requests\Application\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditUserRequest extends FormRequest
{
    public function rules(): array
    {
        $userId = $this->route('user_id');
        return [
            'name' => ['required', 'string', 'max:255', 'min:3', Rule::unique('users', 'name')->ignore($userId)],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($userId)],
            'role' => ['required', 'integer', Rule::exists('roles', 'id')]
        ];
    }
}
