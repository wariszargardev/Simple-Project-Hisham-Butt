<?php

namespace App\Http\Requests\Api\User;

use App\Traits\ApiFailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    use ApiFailedValidationTrait;

    public function rules()
    {
        return [
            'token' => 'required',
            'password' => 'required|min:8',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
