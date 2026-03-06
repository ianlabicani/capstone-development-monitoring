<?php

namespace App\Http\Controllers\TechnicalAdviser;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamLeaderRequest;
use App\Http\Requests\UpdateTeamLeaderRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeamLeaderController extends Controller
{
    public function index()
    {
        $teamLeaders = Auth::user()->createdUsers()
            ->whereHas('roles', function ($query) {
                $query->where('name', UserRole::TeamLeader->value);
            })->get();

        return view('technical-adviser.team-leaders.index', compact('teamLeaders'));
    }

    public function create()
    {
        return view('technical-adviser.team-leaders.create');
    }

    public function store(StoreTeamLeaderRequest $request)
    {
        $user = User::create([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'password' => Hash::make('password'),
            'must_change_password' => true,
            'created_by' => Auth::id(),
        ]);

        $user->assignRole(UserRole::TeamLeader->value);

        return redirect()
            ->route('technical-adviser.team-leaders.show', $user)
            ->with('success', "Team leader '{$user->name}' created successfully. Password: password (please change it after logging in).");
    }

    public function show(User $user)
    {
        return view('technical-adviser.team-leaders.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('technical-adviser.team-leaders.edit', compact('user'));
    }

    public function update(UpdateTeamLeaderRequest $request, User $user)
    {
        $user->update($request->validated());

        return redirect()
            ->route('technical-adviser.team-leaders.show', $user)
            ->with('success', "Team leader '{$user->name}' updated successfully.");
    }

    public function destroy(User $user)
    {
        $name = $user->name;
        $user->delete();

        return redirect()
            ->route('technical-adviser.team-leaders.index')
            ->with('success', "Team leader '{$name}' deleted successfully.");
    }
}
