<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCapstoneTeacherRequest;
use App\Http\Requests\UpdateCapstoneTeacherRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CapstoneTeacherController extends Controller
{
    public function index()
    {
        $capstoneTeachers = User::whereHas('roles', function ($query) {
            $query->where('name', UserRole::CapstoneTeacher->value);
        })->get();

        return view('admin.capstone-teachers.index', compact('capstoneTeachers'));
    }

    public function create()
    {
        return view('admin.capstone-teachers.create');
    }

    public function store(StoreCapstoneTeacherRequest $request)
    {

        $user = User::create([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'password' => Hash::make('password'),
            'must_change_password' => true,
        ]);

        $user->assignRole(UserRole::CapstoneTeacher->value);

        return redirect()
            ->route('admin.capstone-teachers.show', $user)
            ->with('success', "Capstone teacher '{$user->name}' created successfully. Password: password (please change it after logging in).");
    }

    public function show(User $user)
    {
        return view('admin.capstone-teachers.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.capstone-teachers.edit', compact('user'));
    }

    public function update(UpdateCapstoneTeacherRequest $request, User $user)
    {
        $user->update($request->validated());

        return redirect()
            ->route('admin.capstone-teachers.show', $user)
            ->with('success', "Capstone teacher '{$user->name}' updated successfully.");
    }

    public function destroy(User $user)
    {
        $name = $user->name;
        $user->delete();

        return redirect()
            ->route('admin.capstone-teachers.index')
            ->with('success', "Capstone teacher '{$name}' deleted successfully.");
    }
}
