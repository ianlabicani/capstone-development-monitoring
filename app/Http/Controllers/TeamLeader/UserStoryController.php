<?php

namespace App\Http\Controllers\TeamLeader;

use App\Enums\UserStoryStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeamLeader\CreateUserStoryRequest;
use App\Http\Requests\TeamLeader\UpdateUserStoryRequest;
use App\Models\UserStory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UserStoryController extends Controller
{
    public function update(UpdateUserStoryRequest $request, UserStory $story): RedirectResponse
    {
        $team = Auth::user()->team;

        abort_unless($team && $story->team_id === $team->id, 403);

        $story->update([
            'title' => $request->validated('title'),
            'description' => $request->validated('description'),
        ]);

        return back()->with('success', 'User story updated.');
    }

    public function approve(UserStory $story): RedirectResponse
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

    public function delete(UserStory $story): RedirectResponse
    {
        $team = Auth::user()->team;

        abort_unless($team && $story->team_id === $team->id, 403);

        $story->delete();

        return back()->with('success', 'User story deleted.');
    }

    public function approveAll(): RedirectResponse
    {
        $team = Auth::user()->team;

        abort_unless($team, 403);

        $draftCount = $team->userStories()
            ->where('status', UserStoryStatus::Draft->value)
            ->count();

        $team->userStories()
            ->where('status', UserStoryStatus::Draft->value)
            ->update(['status' => UserStoryStatus::Approved->value]);

        return back()->with('success', "Approved {$draftCount} story".($draftCount !== 1 ? 'ies' : '').'.');
    }

    public function store(CreateUserStoryRequest $request): RedirectResponse
    {
        $team = Auth::user()->team;

        abort_unless($team, 403);

        $nextSort = $team->userStories()->max('sort_order') ?? 0;
        $currentVersion = $team->userStories()->max('version') ?? 'v1';

        $team->userStories()->create([
            'title' => $request->validated('title'),
            'description' => $request->validated('description'),
            'status' => UserStoryStatus::Draft->value,
            'sort_order' => $nextSort + 1,
            'version' => $currentVersion,
            'manually_created' => true,
        ]);

        return back()->with('success', 'User story created.');
    }

    public function toggleAchievementStatus(UserStory $story): RedirectResponse
    {
        $team = Auth::user()->team;

        abort_unless($team && $story->team_id === $team->id, 403);

        // When manually toggling achievement, mark it as manually updated
        $story->update([
            'is_achieved' => ! $story->is_achieved,
            'manually_achieved_at' => $story->is_achieved ? null : now(),
        ]);

        return back()->with('success', $story->is_achieved
            ? 'Story marked as achieved.'
            : 'Story marked as not achieved.');
    }
}
