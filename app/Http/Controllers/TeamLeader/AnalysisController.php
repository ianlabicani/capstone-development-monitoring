<?php

namespace App\Http\Controllers\TeamLeader;

use App\Enums\UserStoryStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeamLeader\SaveTextDocumentRequest;
use App\Http\Requests\TeamLeader\UploadTeamDocumentRequest;
use App\Jobs\GenerateUserStoriesJob;
use App\Jobs\MatchStoriesToCommitsJob;
use App\Models\TeamDocument;
use App\Services\GitHubService;
use App\Services\ProgressSummaryService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AnalysisController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        $team = Auth::user()->team;

        if (! $team) {
            return redirect()->route('team-leader.team.create');
        }

        $team->load(['documents', 'repositories']);

        $approvedStories = $team->userStories()->where('status', UserStoryStatus::Approved);
        $totalApproved = $approvedStories->count();
        $coveredCount = $approvedStories->where('is_covered', true)->count();
        $gapCount = $totalApproved - $coveredCount;
        $progressPercent = $totalApproved > 0 ? round(($coveredCount / $totalApproved) * 100) : null;

        // Get all available versions
        $allVersions = $team->userStories()->distinct()->pluck('version')->sort()->reverse()->values();
        $latestVersion = $allVersions->first();

        // Get filter parameters from URL with defaults
        $selectedVersion = $request->query('version', $latestVersion);
        $selectedStatus = $request->query('status', 'draft');

        // Build the query
        $query = $team->userStories();

        // Filter by version (optional - if not 'all')
        if ($selectedVersion !== 'all') {
            $query = $query->where('version', $selectedVersion);
        }

        // Apply status filter
        if ($selectedStatus === 'approved') {
            $query = $query->where('status', UserStoryStatus::Approved);
        } elseif ($selectedStatus === 'draft') {
            $query = $query->where('status', UserStoryStatus::Draft);
        } elseif ($selectedStatus === 'gap') {
            // Gaps = Approved but not covered
            $query = $query->where('status', UserStoryStatus::Approved)->where('is_covered', false);
        }

        // Paginate results (15 per page)
        $stories = $query->paginate(15);

        $today = now()->timezone('Asia/Manila')->toDateString();
        $isSameDay = $team->generation_date?->toDateString() === $today;
        $generationsToday = $isSameDay ? $team->generation_count_today : 0;
        $generationLimitReached = $generationsToday >= 2;
        $manilaTime = now()->timezone('Asia/Manila');
        $secondsUntilReset = max(0, (int) $manilaTime->diffInSeconds($manilaTime->copy()->endOfDay()->addSecond()));

        return view('team-leader.analysis.show', compact(
            'team',
            'totalApproved',
            'coveredCount',
            'gapCount',
            'progressPercent',
            'stories',
            'allVersions',
            'selectedVersion',
            'selectedStatus',
            'generationsToday',
            'generationLimitReached',
            'secondsUntilReset',
        ));
    }

    public function uploadDocument(UploadTeamDocumentRequest $request): RedirectResponse
    {
        $team = Auth::user()->team;

        abort_unless($team, 403);

        $slot = $request->validated('slot');

        $existing = $team->documents()->where('slot', $slot)->first();
        if ($existing) {
            Storage::disk('local')->delete($existing->file_path);
            $existing->delete();
        }

        $file = $request->file('document');
        $path = $file->store("team-documents/{$team->id}", 'local');

        $team->documents()->create([
            'slot' => $slot,
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
        ]);

        if ($team->analysis_status === 'completed') {
            $team->update(['analysis_status' => 'stale']);

            $team->userStories()
                ->where('status', UserStoryStatus::Approved)
                ->update(['status' => UserStoryStatus::Outdated->value]);
        }

        return back()->with('success', 'Document uploaded successfully.');
    }

    public function deleteDocument(TeamDocument $document): RedirectResponse
    {
        $team = Auth::user()->team;

        abort_unless($team && $document->team_id === $team->id, 403);

        Storage::disk('local')->delete($document->file_path);
        $document->delete();

        if ($team->analysis_status === 'completed') {
            $team->update(['analysis_status' => 'stale']);
        }

        return back()->with('success', 'Document removed.');
    }

    public function saveText(SaveTextDocumentRequest $request): RedirectResponse
    {
        $team = Auth::user()->team;

        abort_unless($team, 403);

        $textDoc = $team->documents()->where('type', 'text')->first();

        if ($textDoc) {
            $textDoc->update(['content' => $request->validated('content')]);
        } else {
            $nextSlot = ($team->documents()->where('type', 'file')->max('slot') ?? 0) + 1;

            $team->documents()->create([
                'slot' => max($nextSlot, 3),
                'type' => 'text',
                'content' => $request->validated('content'),
            ]);
        }

        if ($team->analysis_status === 'completed') {
            $team->update(['analysis_status' => 'stale']);

            $team->userStories()
                ->where('status', UserStoryStatus::Approved)
                ->update(['status' => UserStoryStatus::Outdated->value]);
        }

        return back()->with('success', 'Project description saved.');
    }

    public function deleteText(): RedirectResponse
    {
        $team = Auth::user()->team;

        abort_unless($team, 403);

        $textDoc = $team->documents()->where('type', 'text')->first();

        if ($textDoc) {
            $textDoc->delete();
        }

        if ($team->analysis_status === 'completed') {
            $team->update(['analysis_status' => 'stale']);
        }

        return back()->with('success', 'Project description removed.');
    }

    public function generate(Request $request): RedirectResponse
    {
        $team = Auth::user()->team;

        abort_unless($team, 403);

        $validated = $request->validate([
            'source' => ['required', 'in:files,text'],
        ]);

        $source = $validated['source'];

        if ($source === 'files' && $team->documents()->where('type', 'file')->count() === 0) {
            return back()->withErrors(['generate' => 'Upload at least one file document before generating.']);
        }

        if ($source === 'text' && ! $team->documents()->where('type', 'text')->exists()) {
            return back()->withErrors(['generate' => 'Save your project description before generating.']);
        }

        if ($team->analysis_status === 'processing') {
            return back()->withErrors(['generate' => 'Analysis is already being generated.']);
        }

        $today = now()->timezone('Asia/Manila')->toDateString();
        $isSameDay = $team->generation_date?->toDateString() === $today;
        $generationsToday = $isSameDay ? $team->generation_count_today : 0;

        if ($generationsToday >= 2) {
            return back()->withErrors(['generate' => 'Daily limit reached. You can generate again tomorrow (midnight, Manila time).']);
        }

        $team->update(['analysis_status' => 'processing']);
        GenerateUserStoriesJob::dispatch($team, $source);

        return back()->with('success', 'Analysis generation started. Come back in a few minutes to review the generated stories.');
    }

    public function syncAnalysis(GitHubService $github, ProgressSummaryService $summaryService): RedirectResponse
    {
        $team = Auth::user()->team;

        abort_unless($team, 403);

        $team->load('repositories');
        $syncedCount = 0;

        foreach ($team->repositories as $repository) {
            $since = $repository->last_synced_at?->toIso8601String();

            try {
                $commits = $github->fetchCommits(
                    $repository->github_owner,
                    $repository->github_repo,
                    $repository->default_branch,
                    $since,
                );
            } catch (RequestException $e) {
                continue;
            }

            foreach ($commits as $commitData) {
                $repository->commits()->updateOrCreate(
                    ['sha' => $commitData['sha']],
                    $commitData,
                );
                $syncedCount++;
            }

            $repository->update(['last_synced_at' => now()]);
        }

        if ($team->userStories()->where('status', 'approved')->exists()) {
            MatchStoriesToCommitsJob::dispatch($team);
        }

        // Generate AI summary
        $summary = $summaryService->generateSummary($team);
        $team->update(['progress_summary' => $summary]);

        return back()->with('success', "Synced {$syncedCount} commit(s). Development progress updated.");
    }
}
