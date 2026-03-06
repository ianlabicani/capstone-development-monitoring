<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTechnicalAdviserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The technical adviser name is required.',
            'name.string' => 'The technical adviser name must be a string.',
            'name.max' => 'The technical adviser name cannot exceed 255 characters.',
            'email.required' => 'An email address is required.',
            'email.email' => 'A valid email address is required.',
            'email.unique' => 'This email address is already in use.',
        ];
    }
}
