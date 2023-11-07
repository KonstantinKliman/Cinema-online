<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class PhotoProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'profile_photo' => ['dimensions:min_width=500,min_height=500', 'dimensions:max_width=500,max_height=500', 'image', 'max:2048'],
        ];
    }
}
