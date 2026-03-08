<?php

namespace App\Jobs;

use App\Models\Team;
use App\Services\StoryMatchingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class MatchStoriesToCommitsJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public Team $team) {}

    public function handle(StoryMatchingService $matcher): void
    {
        $matcher->matchForTeam($this->team);
    }
}
