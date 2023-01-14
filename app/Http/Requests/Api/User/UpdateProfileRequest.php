<?php

namespace App\Http\Requests\Api\User;

use App\Traits\ApiFailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    use ApiFailedValidationTrait;

    public function rules()
    {
        return [
            'name' => 'required|min:3|max:200',
            'age' => 'required',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
