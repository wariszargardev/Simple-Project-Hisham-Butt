<?php

namespace App\Http\Requests\Api\User;

use App\Traits\ApiFailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    use ApiFailedValidationTrait;

    public function rules()
    {
        return [
            'email' => 'required',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
