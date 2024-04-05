<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'permissions' => ['required'],
            'permissions.*' => ['required', 'integer', Rule::exists('permissions', 'id')],
        ];
    }
}
