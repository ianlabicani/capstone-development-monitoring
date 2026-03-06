<?php

namespace App\Http\Requests\TeamLeader;

use Illuminate\Foundation\Http\FormRequest;

class StoreRepositoryRequest extends FormRequest
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
            'github_owner' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\-]+$/'],
            'github_repo' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9._\-]+$/'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'github_owner.required' => 'The repository owner is required.',
            'github_owner.regex' => 'The owner can only contain letters, numbers, and hyphens.',
            'github_repo.required' => 'The repository name is required.',
            'github_repo.regex' => 'The repository name can only contain letters, numbers, dots, hyphens, and underscores.',
        ];
    }
}
