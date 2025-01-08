<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        // Allow all users to make this request
        return true;
    }

    public function rules()
    {
        return [
            'login' => 'required|string',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages()
    {
        return [
            'login.required' => 'The login field is required.',
            'login.string' => 'The login field must be a string.',
            'password.required' => 'The password field is required.',
            'password.string' => 'The password field must be a string.',
            'password.min' => 'The password must be at least 6 characters.',
        ];
    }
}
