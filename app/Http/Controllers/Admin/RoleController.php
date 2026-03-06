<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Permission;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();

        return view('admin.roles.index', compact('roles'));
    }

    public function show(Role $role)
    {
        $role->load('permissions');

        return view('admin.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $role->load('permissions');
        $allPermissions = Permission::cases();

        return view('admin.roles.edit', compact('role', 'allPermissions'));
    }

    public function update(Role $role)
    {
        $permissions = collect(request()->input('permissions', []))
            ->filter(fn ($permission) => in_array($permission, array_map(fn ($p) => $p->value, Permission::cases())))
            ->values()
            ->toArray();

        $role->syncPermissions($permissions);

        return redirect()
            ->route('admin.roles.show', $role)
            ->with('success', "Role '{$role->name}' permissions updated successfully.");
    }
}
