<?php

namespace App\Http\Controllers\TeamLeader;

use App\Enums\UserStoryStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeamLeader\UpdateUserStoryRequest;
use App\Http\Requests\TeamLeader\UploadTeamDocumentRequest;
use App\Jobs\GenerateUserStoriesJob;
use App\Models\TeamDocument;
use App\Models\UserStory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AnalysisController extends Controller
{
    public function show(): View|RedirectResponse
    {
        $team = Auth::user()->team;

        if (! $team) {
            return redirect()->route('team-leader.team.create');
        }

        $team->load(['documents', 'userStories', 'repositories']);

        $approvedStories = $team->userStories->where('status', UserStoryStatus::Approved);
        $totalApproved = $approvedStories->count();
        $coveredCount = $approvedStories->where('is_covered', true)->count();
        $gapCount = $totalApproved - $coveredCount;
        $progressPercent = $totalApproved > 0 ? round(($coveredCount / $totalApproved) * 100) : null;

        return view('team-leader.analysis.show', compact(
            'team',
            'totalApproved',
            'coveredCount',
            'gapCount',
            'progressPercent',
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

    public function generate(): RedirectResponse
    {
        $team = Auth::user()->team;

        abort_unless($team, 403);

        if ($team->documents()->count() === 0) {
            return back()->withErrors(['generate' => 'Upload at least one document before generating analysis.']);
        }

        if ($team->analysis_status === 'processing') {
            return back()->withErrors(['generate' => 'Analysis is already being generated.']);
        }

        GenerateUserStoriesJob::dispatch($team);

        return back()->with('success', 'Analysis generation started. This may take a moment.');
    }

    public function updateStory(UpdateUserStoryRequest $request, UserStory $story): RedirectResponse
    {
        $team = Auth::user()->team;

        abort_unless($team && $story->team_id === $team->id, 403);

        $story->update([
            'title' => $request->validated('title'),
            'description' => $request->validated('description'),
        ]);

        return back()->with('success', 'User story updated.');
    }

    public function approveStory(UserStory $story): RedirectResponse
    {
        $team = Auth::user()->team;

        abort_unless($team && $story->team_id === $team->id, 403);

        $newStatus = $story->status === UserStoryStatus::Approved
            ? UserStoryStatus::Draft
            : UserStoryStatus::Approved;

        $story->update(['status' => $newStatus->value]);

        return back()->with('success', $newStatus === UserStoryStatus::Approved
            ? 'Story approved.'
            : 'Story moved back to draft.');
    }

    public function deleteStory(UserStory $story): RedirectResponse
    {
        $team = Auth::user()->team;

        abort_unless($team && $story->team_id === $team->id, 403);

        $story->delete();

        return back()->with('success', 'User story deleted.');
    }
}
