<?php

namespace App\Http\Requests\TeamLeader;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UploadTeamDocumentRequest extends FormRequest
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
            'document' => ['required', File::types(['pdf', 'txt'])->max(10 * 1024)],
            'slot' => ['required', 'integer', 'in:1,2'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'document.required' => 'Please select a file to upload.',
            'document.max' => 'The document must not exceed 10MB.',
            'slot.required' => 'Please specify which document slot to use.',
            'slot.in' => 'Invalid document slot.',
        ];
    }
}
