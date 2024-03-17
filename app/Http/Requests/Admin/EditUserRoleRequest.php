<?php

namespace App\Http\Requests\Admin;

use App\Enums\RoleType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditUserRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'role' => [Rule::enum(RoleType::class),],
        ];
    }
}
