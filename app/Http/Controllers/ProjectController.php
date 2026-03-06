<?php

namespace App\Http\Controllers;

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

        return view('projects.show', compact(
            'team',
            'totalCommits',
            'contributors',
            'recentCommits',
        ));
    }
}
