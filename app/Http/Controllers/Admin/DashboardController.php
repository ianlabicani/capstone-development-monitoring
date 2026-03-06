<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class DashboardController
{
    public function __invoke(): View
    {
        $capstoneTeachersCount = User::whereHas('roles', function ($query) {
            $query->where('name', UserRole::CapstoneTeacher->value);
        })->count();

        $technicalAdvisersCount = User::whereHas('roles', function ($query) {
            $query->where('name', UserRole::TechnicalAdviser->value);
        })->count();

        $rolesCount = Role::count();

        return view('admin.dashboard', compact(
            'capstoneTeachersCount',
            'technicalAdvisersCount',
            'rolesCount',
        ));
    }
}
