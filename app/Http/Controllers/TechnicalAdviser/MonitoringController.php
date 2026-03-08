<?php

namespace App\Http\Controllers\TechnicalAdviser;

use App\Enums\UserStoryStatus;
use App\Http\Controllers\Controller;
use App\Models\Commit;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MonitoringController extends Controller
{
    public function index(): View
    {
        $teamLeaderIds = Auth::user()->createdUsers()->pluck('id');

        $teams = Team::whereIn('user_id', $teamLeaderIds)
            ->with(['owner', 'repositories' => function ($query) {
                $query->withCount('commits');
            }])
            ->get()
            ->map(function ($team) {
                $repositoryIds = $team->repositories->pluck('id');

                $team->total_commits = $team->repositories->sum('commits_count');
                $team->weekly_commits = $repositoryIds->isNotEmpty()
                    ? Commit::whereIn('repository_id', $repositoryIds)
                        ->where('committed_at', '>=', now()->subWeek())
                        ->count()
                    : 0;
                $team->contributors_count = $repositoryIds->isNotEmpty()
                    ? Commit::whereIn('repository_id', $repositoryIds)
                        ->distinct('author_email')
                        ->count('author_email')
                    : 0;

                return $team;
            });

        return view('technical-adviser.monitoring.index', compact('teams'));
    }

    public function show(Team $team): View
    {
        $teamLeaderIds = Auth::user()->createdUsers()->pluck('id');

        abort_unless($teamLeaderIds->contains($team->user_id), 403);

        $team->load(['owner', 'documents', 'repositories' => function ($query) {
            $query->withCount('commits');
        }]);

        $repositoryIds = $team->repositories->pluck('id');

        $totalCommits = $team->repositories->sum('commits_count');

        $weeklyCommits = Commit::whereIn('repository_id', $repositoryIds)
            ->where('committed_at', '>=', now()->subWeek())
            ->count();

        $contributors = Commit::whereIn('repository_id', $repositoryIds)
            ->distinct('author_email')
            ->count('author_email');

        $recentCommits = Commit::whereIn('repository_id', $repositoryIds)
            ->with('repository')
            ->latest('committed_at')
            ->limit(20)
            ->get();

        $approvedStories = $team->userStories()->where('status', UserStoryStatus::Approved)->get();
        $totalApproved = $approvedStories->count();
        $coveredCount = $approvedStories->where('is_covered', true)->count();
        $gapCount = $totalApproved - $coveredCount;
        $progressPercent = $totalApproved > 0 ? round(($coveredCount / $totalApproved) * 100) : 0;

        return view('technical-adviser.monitoring.show', compact(
            'team',
            'totalCommits',
            'weeklyCommits',
            'contributors',
            'recentCommits',
            'approvedStories',
            'totalApproved',
            'coveredCount',
            'gapCount',
            'progressPercent',
        ));
    }
}
