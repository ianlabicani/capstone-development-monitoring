<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTechnicalAdviserRequest;
use App\Http\Requests\UpdateTechnicalAdviserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TechnicalAdviserController extends Controller
{
    public function index()
    {
        $technicalAdvisers = User::whereHas('roles', function ($query) {
            $query->where('name', UserRole::TechnicalAdviser->value);
        })->get();

        return view('admin.technical-advisers.index', compact('technicalAdvisers'));
    }

    public function create()
    {
        return view('admin.technical-advisers.create');
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
            ->route('admin.technical-advisers.show', $user)
            ->with('success', "Technical adviser '{$user->name}' created successfully. Password: password (please change it after logging in).");
    }

    public function show(User $user)
    {
        return view('admin.technical-advisers.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.technical-advisers.edit', compact('user'));
    }

    public function update(UpdateTechnicalAdviserRequest $request, User $user)
    {
        $user->update($request->validated());

        return redirect()
            ->route('admin.technical-advisers.show', $user)
            ->with('success', "Technical adviser '{$user->name}' updated successfully.");
    }

    public function destroy(User $user)
    {
        $name = $user->name;
        $user->delete();

        return redirect()
            ->route('admin.technical-advisers.index')
            ->with('success', "Technical adviser '{$name}' deleted successfully.");
    }
}
