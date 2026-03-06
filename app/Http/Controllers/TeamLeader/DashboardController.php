<?php

namespace App\Http\Controllers\TeamLeader;

use App\Http\Controllers\Controller;
use App\Models\Commit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View|RedirectResponse
    {
        $team = Auth::user()->team;

        if (! $team) {
            return redirect()->route('team-leader.team.create');
        }

        $team->load(['repositories' => function ($query) {
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

        return view('team-leader.dashboard', compact(
            'team',
            'totalCommits',
            'weeklyCommits',
            'contributors',
            'recentCommits',
        ));
    }
}
