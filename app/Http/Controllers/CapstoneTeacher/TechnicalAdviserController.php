<?php

namespace App\Http\Controllers\CapstoneTeacher;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTechnicalAdviserRequest;
use App\Http\Requests\UpdateTechnicalAdviserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class TechnicalAdviserController extends Controller
{
    public function index(): View
    {
        $technicalAdvisers = User::whereHas('roles', function ($query) {
            $query->where('name', UserRole::TechnicalAdviser->value);
        })->get();

        return view('capstone-teacher.technical-advisers.index', compact('technicalAdvisers'));
    }

    public function create(): View
    {
        return view('capstone-teacher.technical-advisers.create');
    }

    public function store(StoreTechnicalAdviserRequest $request)
    {
        $user = User::create([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'password' => Hash::make('password'),
            'must_change_password' => true,
        ]);

        $user->assignRole(UserRole::TechnicalAdviser->value);

        return redirect()
            ->route('capstone-teacher.technical-advisers.show', $user)
            ->with('success', "Technical adviser '{$user->name}' created successfully. Password: password (please change it after logging in).");
    }

    public function show(User $user): View
    {
        return view('capstone-teacher.technical-advisers.show', compact('user'));
    }

    public function edit(User $user): View
    {
        return view('capstone-teacher.technical-advisers.edit', compact('user'));
    }

    public function update(UpdateTechnicalAdviserRequest $request, User $user)
    {
        $user->update($request->validated());

        return redirect()
            ->route('capstone-teacher.technical-advisers.show', $user)
            ->with('success', "Technical adviser '{$user->name}' updated successfully.");
    }

    public function destroy(User $user)
    {
        $name = $user->name;
        $user->delete();

        return redirect()
            ->route('capstone-teacher.technical-advisers.index')
            ->with('success', "Technical adviser '{$name}' deleted successfully.");
    }
}
