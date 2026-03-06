<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Your current password is required.',
            'current_password.current_password' => 'The current password is incorrect.',
            'password.required' => 'A new password is required.',
            'password.confirmed' => 'The passwords do not match.',
            'password.min' => 'The password must be at least 8 characters.',
        ];
    }
}
