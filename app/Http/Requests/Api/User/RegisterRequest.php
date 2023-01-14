<?php

namespace App\Http\Requests\Api\User;

use App\Traits\ApiFailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    use ApiFailedValidationTrait;

    public function rules()
    {
        return [
            'name' => 'required|min:3|max:200',
            'email' => 'required|unique:users',
            'password' => 'required|min:8|max:25',
            'age' => 'required',
            'profile_picture' => 'required'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
