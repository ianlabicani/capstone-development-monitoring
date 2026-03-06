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
        $teamCount = Team::count();

        $repositoryCount = \App\Models\Repository::count();

        $totalCommits = Commit::count();

        $weeklyCommits = Commit::where('committed_at', '>=', now()->subWeek())->count();

        return view('capstone-teacher.dashboard', compact(
            'teamCount',
            'repositoryCount',
            'totalCommits',
            'weeklyCommits',
        ));
    }
}
