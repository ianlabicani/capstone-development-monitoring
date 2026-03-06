<?php

namespace App\Http\Controllers\CapstoneTeacher;

use App\Http\Controllers\Controller;
use App\Models\Commit;
use App\Models\Team;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
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

        return view('capstone-teacher.dashboard', compact('teams'));
    }
}
