<?php

use App\Http\Controllers\Admin\TechnicalAdviserController as AdminTechnicalAdviserController;
use App\Http\Controllers\CapstoneTeacher\DashboardController as CapstoneTeacherDashboardController;
use App\Http\Controllers\CapstoneTeacher\TeamController as CapstoneTeacherTeamController;
use App\Http\Controllers\CapstoneTeacher\TechnicalAdviserController as CapstoneTeacherTechnicalAdviserController;
use App\Http\Controllers\DashboardRedirectController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamLeader\DashboardController;
use App\Http\Controllers\TeamLeader\RepositoryController;
use App\Http\Controllers\TeamLeader\TeamController;
use App\Http\Controllers\TechnicalAdviser\MonitoringController;
use App\Http\Controllers\TechnicalAdviser\TeamLeaderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardRedirectController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Technical Advisers
    Route::get('technical-advisers', [AdminTechnicalAdviserController::class, 'index'])->middleware('can:manage users')->name('technical-advisers.index');
    Route::get('technical-advisers/create', [AdminTechnicalAdviserController::class, 'create'])->middleware('can:manage users')->name('technical-advisers.create');
    Route::post('technical-advisers', [AdminTechnicalAdviserController::class, 'store'])->middleware('can:manage users')->name('technical-advisers.store');
    Route::get('technical-advisers/{user}', [AdminTechnicalAdviserController::class, 'show'])->middleware('can:manage users')->name('technical-advisers.show');
    Route::get('technical-advisers/{user}/edit', [AdminTechnicalAdviserController::class, 'edit'])->middleware('can:manage users')->name('technical-advisers.edit');
    Route::patch('technical-advisers/{user}', [AdminTechnicalAdviserController::class, 'update'])->middleware('can:manage users')->name('technical-advisers.update');
    Route::delete('technical-advisers/{user}', [AdminTechnicalAdviserController::class, 'destroy'])->middleware('can:manage users')->name('technical-advisers.destroy');
});

// Technical Adviser Routes
Route::middleware(['auth', 'verified'])->prefix('technical-adviser')->name('technical-adviser.')->group(function () {
    // Team Leaders
    Route::get('team-leaders', [TeamLeaderController::class, 'index'])->middleware('can:manage team leaders')->name('team-leaders.index');
    Route::get('team-leaders/create', [TeamLeaderController::class, 'create'])->middleware('can:manage team leaders')->name('team-leaders.create');
    Route::post('team-leaders', [TeamLeaderController::class, 'store'])->middleware('can:manage team leaders')->name('team-leaders.store');
    Route::get('team-leaders/{user}', [TeamLeaderController::class, 'show'])->middleware('can:manage team leaders')->name('team-leaders.show');
    Route::get('team-leaders/{user}/edit', [TeamLeaderController::class, 'edit'])->middleware('can:manage team leaders')->name('team-leaders.edit');
    Route::patch('team-leaders/{user}', [TeamLeaderController::class, 'update'])->middleware('can:manage team leaders')->name('team-leaders.update');
    Route::delete('team-leaders/{user}', [TeamLeaderController::class, 'destroy'])->middleware('can:manage team leaders')->name('team-leaders.destroy');

    // Monitoring
    Route::get('monitoring', [MonitoringController::class, 'index'])->middleware('can:view team progress')->name('monitoring.index');
    Route::get('monitoring/{team}', [MonitoringController::class, 'show'])->middleware('can:view team progress')->name('monitoring.show');
});

// Team Leader Routes
Route::middleware(['auth', 'verified', 'permission:register repository'])->prefix('team-leader')->name('team-leader.')->group(function () {
    // Dashboard
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    // Team Setup
    Route::get('team/create', [TeamController::class, 'create'])->name('team.create');
    Route::post('team', [TeamController::class, 'store'])->name('team.store');
    Route::get('team', [TeamController::class, 'show'])->name('team.show');
    Route::get('team/edit', [TeamController::class, 'edit'])->name('team.edit');
    Route::patch('team', [TeamController::class, 'update'])->name('team.update');

    // Repositories
    Route::get('repositories', [RepositoryController::class, 'index'])->name('repositories.index');
    Route::get('repositories/create', [RepositoryController::class, 'create'])->name('repositories.create');
    Route::post('repositories', [RepositoryController::class, 'store'])->name('repositories.store');
    Route::get('repositories/{repository}', [RepositoryController::class, 'show'])->name('repositories.show');
    Route::post('repositories/{repository}/sync', [RepositoryController::class, 'sync'])->name('repositories.sync');
    Route::delete('repositories/{repository}', [RepositoryController::class, 'destroy'])->name('repositories.destroy');
});

// Capstone Teacher Routes
Route::middleware(['auth', 'verified', 'role:capstone_teacher'])->prefix('capstone-teacher')->name('capstone-teacher.')->group(function () {
    // Dashboard
    Route::get('dashboard', CapstoneTeacherDashboardController::class)->middleware('can:view dashboard')->name('dashboard');

    // Team Progress Monitoring
    Route::get('team/{team}', [CapstoneTeacherTeamController::class, 'show'])->middleware('can:view team progress')->name('team.show');

    // Technical Advisers
    Route::get('technical-advisers', [CapstoneTeacherTechnicalAdviserController::class, 'index'])->middleware('can:manage team leaders')->name('technical-advisers.index');
    Route::get('technical-advisers/create', [CapstoneTeacherTechnicalAdviserController::class, 'create'])->middleware('can:manage team leaders')->name('technical-advisers.create');
    Route::post('technical-advisers', [CapstoneTeacherTechnicalAdviserController::class, 'store'])->middleware('can:manage team leaders')->name('technical-advisers.store');
    Route::get('technical-advisers/{user}', [CapstoneTeacherTechnicalAdviserController::class, 'show'])->middleware('can:manage team leaders')->name('technical-advisers.show');
    Route::get('technical-advisers/{user}/edit', [CapstoneTeacherTechnicalAdviserController::class, 'edit'])->middleware('can:manage team leaders')->name('technical-advisers.edit');
    Route::patch('technical-advisers/{user}', [CapstoneTeacherTechnicalAdviserController::class, 'update'])->middleware('can:manage team leaders')->name('technical-advisers.update');
    Route::delete('technical-advisers/{user}', [CapstoneTeacherTechnicalAdviserController::class, 'destroy'])->middleware('can:manage team leaders')->name('technical-advisers.destroy');
});

// Public Project Pages
Route::get('projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');

// Public Leaderboards
Route::prefix('leaderboard')->name('leaderboard.')->group(function () {
    Route::get('teams/{period?}', [LeaderboardController::class, 'teams'])
        ->where('period', 'week|month|all')
        ->defaults('period', 'week')
        ->name('teams');
    Route::get('contributors/{period?}', [LeaderboardController::class, 'contributors'])
        ->where('period', 'week|month|all')
        ->defaults('period', 'week')
        ->name('contributors');
});

require __DIR__.'/auth.php';
