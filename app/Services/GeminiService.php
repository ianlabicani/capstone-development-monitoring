<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class GeminiService
{
    private string $apiKey;

    private string $model;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->model = config('services.gemini.model');
    }

    /**
     * Generate user stories from extracted PDF text.
     *
     * @param  array<int, array{title: string, description: string}>  $existingStories
     * @return array<int, array{title: string, description: string, keywords: array<string>}>
     *
     * @throws RequestException
     */
    public function generateUserStories(string $pdfText, array $existingStories = []): array
    {
        $prompt = $this->buildPrompt($pdfText, $existingStories);

        $response = Http::throw()
            ->post(
                "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$this->apiKey}",
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'responseMimeType' => 'application/json',
                        'temperature' => 0.3,
                    ],
                ]
            );

        $text = $response->json('candidates.0.content.parts.0.text', '[]');

        return json_decode($text, true) ?: [];
    }

    /**
     * @param  array<int, array{title: string, description: string}>  $existingStories
     */
    private function buildPrompt(string $pdfText, array $existingStories = []): string
    {
        $existingSection = '';

        if (! empty($existingStories)) {
            $storyList = collect($existingStories)
                ->map(fn (array $story, int $i): string => ($i + 1).'. '.$story['title'].': '.$story['description'])
                ->implode("\n");

            $existingSection = "\n\nDO NOT duplicate these existing user stories — generate only NEW stories not already covered:\n".$storyList;
        }

        return <<<PROMPT
You are a software engineering analyst. Based on the following project documentation, generate a list of user stories for a software development project.

Each user story must follow the format: "As a [role], I want [feature] so that [benefit]"

Return a JSON array of objects with these exact keys:
- "title": The user story in the standard format (string)
- "description": A brief elaboration of acceptance criteria or scope (string)
- "keywords": An array of 3-8 lowercase keywords that would appear in commit messages related to this story (array of strings)

Generate between 5 and 25 user stories depending on the project scope described.
Focus on functional requirements only. Be specific and actionable.
{$existingSection}

PROJECT DOCUMENTATION:
{$pdfText}
PROMPT;
    }
}
