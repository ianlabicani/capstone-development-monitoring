<?php

namespace App\Http\Controllers\TeamLeader;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamLeader\StoreTeamRequest;
use App\Http\Requests\TeamLeader\UpdateTeamRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    public function create()
    {
        $user = Auth::user();

        if ($user->team) {
            return redirect()->route('team-leader.team.show');
        }

        return view('team-leader.team.create');
    }

    public function store(StoreTeamRequest $request)
    {
        $user = Auth::user();

        if ($user->team) {
            return redirect()->route('team-leader.team.show');
        }

        $user->team()->create([
            'name' => $request->validated('name'),
            'slug' => Str::slug($request->validated('name')),
            'description' => $request->validated('description'),
        ]);

        return redirect()
            ->route('team-leader.team.show')
            ->with('success', 'Team created successfully.');
    }

    public function show()
    {
        $user = Auth::user();

        if (! $user->team) {
            return redirect()->route('team-leader.team.create');
        }

        $team = $user->team->load('repositories');

        return view('team-leader.team.show', compact('team'));
    }

    public function edit()
    {
        $user = Auth::user();
        $team = $user->team;

        if (! $team) {
            return redirect()->route('team-leader.team.create');
        }

        return view('team-leader.team.edit', compact('team'));
    }

    public function update(UpdateTeamRequest $request)
    {
        $team = Auth::user()->team;

        $data = [
            'name' => $request->validated('name'),
            'slug' => Str::slug($request->validated('name')),
            'description' => $request->validated('description'),
        ];

        $team->update($data);

        return redirect()
            ->route('team-leader.team.show')
            ->with('success', 'Team updated successfully.');
    }
}
