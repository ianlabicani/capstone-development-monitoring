<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use Illuminate\Support\Facades\Auth;

class DashboardRedirectController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        if ($user->hasRole(UserRole::CapstoneTeacher->value)) {
            return redirect()->route('capstone-teacher.dashboard');
        }

        if ($user->hasRole(UserRole::TechnicalAdviser->value)) {
            return redirect()->route('technical-adviser.monitoring.index');
        }

        if ($user->hasRole(UserRole::TeamLeader->value)) {
            return redirect()->route('team-leader.dashboard');
        }

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        // Default view
        return view('dashboard');
    }
}
