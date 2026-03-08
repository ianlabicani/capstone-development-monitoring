<?php

namespace App\Http\Requests\TeamLeader;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserStoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Story title is required.',
            'title.max' => 'Story title must not exceed 255 characters.',
            'description.required' => 'Story description is required.',
            'description.max' => 'Story description must not exceed 1000 characters.',
        ];
    }
}
