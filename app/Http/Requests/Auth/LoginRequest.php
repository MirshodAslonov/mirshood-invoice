<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            "email" => "required|email",
            "password" => "required"
        ];
    }

    public function failedValidation($validator)
    {
        failedValidation($validator);
    }
}
