<?php

namespace App\Http\Controllers\CapstoneTeacher;

use App\Http\Controllers\Controller;
use App\Models\Commit;
use App\Models\Team;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function show(Team $team): View
    {
        $team->load(['owner', 'repositories' => function ($query) {
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

        return view('capstone-teacher.team.show', compact(
            'team',
            'totalCommits',
            'weeklyCommits',
            'contributors',
            'recentCommits',
        ));
    }
}
