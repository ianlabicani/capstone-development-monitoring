<?php

namespace App\Http\Controllers\TeamLeader;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamLeader\StoreRepositoryRequest;
use App\Jobs\MatchStoriesToCommitsJob;
use App\Models\Repository;
use App\Services\GitHubService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Auth;

class RepositoryController extends Controller
{
    public function index()
    {
        $team = Auth::user()->team;

        if (! $team) {
            return redirect()->route('team-leader.team.create');
        }

        $repositories = $team->repositories()->withCount('commits')->latest()->get();

        return view('team-leader.repositories.index', compact('team', 'repositories'));
    }

    public function create()
    {
        $team = Auth::user()->team;

        if (! $team) {
            return redirect()->route('team-leader.team.create');
        }

        return view('team-leader.repositories.create', compact('team'));
    }

    public function store(StoreRepositoryRequest $request, GitHubService $github)
    {
        $team = Auth::user()->team;

        if (! $team) {
            return redirect()->route('team-leader.team.create');
        }

        $owner = $request->validated('github_owner');
        $repo = $request->validated('github_repo');

        try {
            $metadata = $github->fetchRepository($owner, $repo);
        } catch (RequestException $e) {
            $status = $e->response->status();
            $message = $status === 404
                ? "Repository '{$owner}/{$repo}' was not found on GitHub."
                : 'Could not connect to GitHub. Please try again.';

            return back()->withInput()->withErrors(['github_repo' => $message]);
        }

        $repository = $team->repositories()->create([
            'github_owner' => $owner,
            'github_repo' => $metadata['name'],
            'full_name' => $metadata['full_name'],
            'default_branch' => $metadata['default_branch'],
            'description' => $metadata['description'],
        ]);

        return redirect()
            ->route('team-leader.repositories.show', $repository)
            ->with('success', "Repository '{$metadata['full_name']}' connected successfully.");
    }

    public function show(Repository $repository)
    {
        $this->authorizeRepository($repository);

        $repository->load(['commits' => function ($query) {
            $query->latest('committed_at');
        }]);

        return view('team-leader.repositories.show', compact('repository'));
    }

    public function sync(Repository $repository, GitHubService $github)
    {
        $this->authorizeRepository($repository);

        $since = $repository->last_synced_at?->toIso8601String();

        try {
            $commits = $github->fetchCommits(
                $repository->github_owner,
                $repository->github_repo,
                $repository->default_branch,
                $since,
            );
        } catch (RequestException $e) {
            return back()->withErrors(['sync' => 'Failed to fetch commits from GitHub. Please try again.']);
        }

        $newCount = 0;
        foreach ($commits as $commitData) {
            $repository->commits()->updateOrCreate(
                ['sha' => $commitData['sha']],
                $commitData,
            );
            $newCount++;
        }

        $repository->update(['last_synced_at' => now()]);

        $team = $repository->team;
        if ($team->userStories()->where('status', 'approved')->exists()) {
            MatchStoriesToCommitsJob::dispatch($team);
        }

        return back()->with('success', "Synced {$newCount} commit(s) from GitHub.");
    }

    public function destroy(Repository $repository)
    {
        $this->authorizeRepository($repository);

        $name = $repository->full_name;
        $repository->delete();

        return redirect()
            ->route('team-leader.repositories.index')
            ->with('success', "Repository '{$name}' removed.");
    }

    private function authorizeRepository(Repository $repository): void
    {
        $team = Auth::user()->team;

        abort_unless($team && $repository->team_id === $team->id, 403);
    }
}
