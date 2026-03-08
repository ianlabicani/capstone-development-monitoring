<?php

namespace App\Http\Controllers;

use App\Enums\UserStoryStatus;
use App\Models\Commit;
use App\Models\Team;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function show(string $slug): View
    {
        $team = Team::where('slug', $slug)
            ->with(['repositories' => function ($query) {
                $query->withCount('commits');
            }])
            ->firstOrFail();

        $repositoryIds = $team->repositories->pluck('id');

        $totalCommits = $team->repositories->sum('commits_count');

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

        return view('projects.show', compact(
            'team',
            'totalCommits',
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
