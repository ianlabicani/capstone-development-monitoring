<?php

namespace App\Services;

use App\Models\Team;
use Illuminate\Support\Facades\Http;

class ProgressSummaryService
{
    private string $apiKey;

    private string $model;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->model = config('services.gemini.model');
    }

    /**
     * Generate an AI summary of the team's development progress.
     */
    public function generateSummary(Team $team): string
    {
        $team->load(['userStories', 'repositories.commits']);

        $approvedStories = $team->userStories()
            ->where('status', 'approved')
            ->get();

        if ($approvedStories->isEmpty()) {
            return 'No approved user stories yet. Generate and approve stories to get a progress summary.';
        }

        $totalApproved = $approvedStories->count();
        $coveredCount = $approvedStories->where('is_covered', true)->count();
        $gapCount = $totalApproved - $coveredCount;

        $commitCount = $team->repositories()
            ->with('commits')
            ->get()
            ->flatMap(fn ($repo) => $repo->commits)
            ->count();

        $storiesText = $approvedStories->map(fn ($story) => "- {$story->title}: {$story->description} [".($story->is_covered ? 'Covered' : 'Gap').']')
            ->join("\n");

        $prompt = <<<PROMPT
You are a technical project analyst. Based on the following development metrics and user stories, provide a concise (2-3 sentences max) summary of the team's development progress and any recommendations.

**Team: {$team->name}**

**Progress Metrics:**
- Total Commits: {$commitCount}
- Approved User Stories: {$totalApproved}
- Stories Covered by Commits: {$coveredCount}
- Development Gaps: {$gapCount}
- Progress: {$this->calculatePercent($coveredCount, $totalApproved)}%

**User Stories:**
{$storiesText}

Provide a brief assessment of the development progress and any key gaps to address.
PROMPT;

        try {
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
                            'temperature' => 0.3,
                        ],
                    ]
                );

            $text = $response->json('candidates.0.content.parts.0.text', '');

            return trim($text) ?: 'Unable to generate summary at this time.';
        } catch (\Exception $e) {
            return 'Could not generate AI summary. Please try again later.';
        }
    }

    /**
     * Calculate percentage.
     */
    private function calculatePercent(int $covered, int $total): int
    {
        return $total > 0 ? round(($covered / $total) * 100) : 0;
    }
}
