<?php

namespace App\Services;

use App\Enums\UserStoryStatus;
use App\Models\Team;

class StoryMatchingService
{
    /**
     * Match approved user stories against commit messages for a team.
     * Updates is_covered on each approved story.
     */
    public function matchForTeam(Team $team): void
    {
        $stories = $team->userStories()
            ->where('status', UserStoryStatus::Approved)
            ->get();

        if ($stories->isEmpty()) {
            return;
        }

        $commitMessages = $team->repositories()
            ->with('commits')
            ->get()
            ->flatMap(fn ($repo) => $repo->commits->pluck('message'))
            ->map(fn ($msg) => mb_strtolower($msg))
            ->all();

        if (empty($commitMessages)) {
            $stories->each(fn ($story) => $story->update(['is_covered' => false]));

            return;
        }

        foreach ($stories as $story) {
            $keywords = $story->keywords ?? [];
            $isCovered = $this->hasKeywordMatch($keywords, $commitMessages);
            $story->update(['is_covered' => $isCovered]);
        }
    }

    /**
     * Check if any keywords appear in any commit messages.
     *
     * @param  array<string>  $keywords
     * @param  array<string>  $commitMessages
     */
    private function hasKeywordMatch(array $keywords, array $commitMessages): bool
    {
        if (empty($keywords)) {
            return false;
        }

        $allMessages = implode(' ', $commitMessages);

        foreach ($keywords as $keyword) {
            if (str_contains($allMessages, mb_strtolower($keyword))) {
                return true;
            }
        }

        return false;
    }
}
