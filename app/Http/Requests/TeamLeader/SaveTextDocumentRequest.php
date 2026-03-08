<?php

namespace App\Http\Requests\TeamLeader;

use Illuminate\Foundation\Http\FormRequest;

class SaveTextDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:50000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'content.required' => 'Please enter your project description.',
            'content.max' => 'The text must not exceed 50,000 characters.',
        ];
    }
}
