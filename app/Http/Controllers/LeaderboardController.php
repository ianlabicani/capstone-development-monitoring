<?php

namespace App\Http\Controllers;

use App\Models\Commit;
use App\Models\Team;
use App\Models\User;
use Illuminate\View\View;

class LeaderboardController extends Controller
{
    public function teams(string $period = 'week'): View
    {
        $adviserId = request('adviser');
        $validPeriods = ['week', 'month', 'all'];

        if (! in_array($period, $validPeriods)) {
            $period = 'week';
        }

        $query = Team::with('owner')
            ->with(['repositories' => function ($q) {
                $q->withCount('commits');
            }])
            ->whereHas('repositories.commits');

        // Calculate commits based on period
        $teamsWithCommits = $query->get()->map(function ($team) {
            $repositoryIds = $team->repositories->pluck('id');

            // Get commit counts by period
            $allTimeCommits = Commit::whereIn('repository_id', $repositoryIds)->count();

            $thisMonthCommits = Commit::whereIn('repository_id', $repositoryIds)
                ->where('committed_at', '>=', now()->startOfMonth())
                ->count();

            $thisWeekCommits = Commit::whereIn('repository_id', $repositoryIds)
                ->where('committed_at', '>=', now()->startOfWeek())
                ->count();

            $contributors = Commit::whereIn('repository_id', $repositoryIds)
                ->distinct('author_email')
                ->count('author_email');

            $team->all_time_commits = $allTimeCommits;
            $team->this_month_commits = $thisMonthCommits;
            $team->this_week_commits = $thisWeekCommits;
            $team->contributors_count = $contributors;

            return $team;
        });

        // Filter by adviser
        if ($adviserId) {
            $teamsWithCommits = $teamsWithCommits->filter(function ($team) use ($adviserId) {
                return $team->owner?->created_by == $adviserId;
            });
        }

        // Sort by current period (descending)
        $sortKey = match ($period) {
            'month' => 'this_month_commits',
            'week' => 'this_week_commits',
            default => 'all_time_commits',
        };

        $teams = $teamsWithCommits->sortByDesc($sortKey)->values();

        // Get list of advisers for filter
        $advisers = User::whereHas('createdUsers')
            ->with('createdUsers')
            ->get();

        return view('leaderboard.teams', compact('teams', 'advisers', 'period', 'adviserId'));
    }

    public function contributors(string $period = 'week'): View
    {
        $validPeriods = ['week', 'month', 'all'];

        if (! in_array($period, $validPeriods)) {
            $period = 'week';
        }

        $query = Commit::query();

        // Filter by period
        $query = match ($period) {
            'month' => $query->where('committed_at', '>=', now()->startOfMonth()),
            'week' => $query->where('committed_at', '>=', now()->startOfWeek()),
            default => $query,
        };

        // Group by author and count
        $contributors = $query->selectRaw('author_login, author_email, author_name, COUNT(*) as commit_count')
            ->whereNotNull('author_login')
            ->groupBy('author_login', 'author_email', 'author_name')
            ->orderByDesc('commit_count')
            ->limit(50)
            ->get()
            ->map(function ($contributor) {
                // Calculate streak (consecutive days of commits)
                $commits = Commit::where('author_email', $contributor->author_email)
                    ->orderByDesc('committed_at')
                    ->get(['committed_at']);

                $streak = $this->calculateStreak($commits);

                $contributor->streak = $streak;

                return $contributor;
            });

        return view('leaderboard.contributors', compact('contributors', 'period'));
    }

    private function calculateStreak($commits): int
    {
        if ($commits->isEmpty()) {
            return 0;
        }

        $streak = 0;
        $currentDate = now()->startOfDay();

        foreach ($commits as $commit) {
            $commitDate = $commit->committed_at->startOfDay();

            if ($commitDate->eq($currentDate)) {
                $streak++;
                $currentDate = $currentDate->subDay();
            } elseif ($commitDate->lt($currentDate)) {
                // Skip dates with no commits
                $currentDate = $commitDate;
                $streak++;
            } else {
                // Commit is in the future, break streak
                break;
            }
        }

        return $streak;
    }
}
