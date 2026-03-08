<?php

namespace App\Http\Controllers\CapstoneTeacher;

use App\Enums\UserStoryStatus;
use App\Http\Controllers\Controller;
use App\Models\Commit;
use App\Models\Team;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        $teams = Team::with(['owner', 'repositories' => function ($query) {
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

        return view('capstone-teacher.teams.index', compact('teams'));
    }

    public function show(Team $team): View
    {
        $team->load(['owner', 'documents', 'repositories' => function ($query) {
            $query->withCount('commits');
        }]);

        $repositoryIds = $team->repositories->pluck('id');

        $totalCommits = $team->repositories->sum('commits_count');

        $weeklyCommits = $repositoryIds->isNotEmpty()
            ? Commit::whereIn('repository_id', $repositoryIds)
                ->where('committed_at', '>=', now()->subWeek())
                ->count()
            : 0;

        $contributors = $repositoryIds->isNotEmpty()
            ? Commit::whereIn('repository_id', $repositoryIds)
                ->distinct('author_email')
                ->count('author_email')
            : 0;

        $recentCommits = $repositoryIds->isNotEmpty()
            ? Commit::whereIn('repository_id', $repositoryIds)
                ->with('repository')
                ->latest('committed_at')
                ->limit(20)
                ->get()
            : collect();

        $approvedStories = $team->userStories()->where('status', UserStoryStatus::Approved)->get();
        $totalApproved = $approvedStories->count();
        $coveredCount = $approvedStories->where('is_covered', true)->count();
        $gapCount = $totalApproved - $coveredCount;
        $progressPercent = $totalApproved > 0 ? round(($coveredCount / $totalApproved) * 100) : 0;

        return view('capstone-teacher.teams.show', compact(
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
