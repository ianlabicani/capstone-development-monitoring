<?php

use App\Http\Controllers\Admin\CapstoneTeacherController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TechnicalAdviserController as AdminTechnicalAdviserController;
use App\Http\Controllers\CapstoneTeacher\DashboardController as CapstoneTeacherDashboardController;
use App\Http\Controllers\CapstoneTeacher\TeamController as CapstoneTeacherTeamController;
use App\Http\Controllers\CapstoneTeacher\TechnicalAdviserController as CapstoneTeacherTechnicalAdviserController;
use App\Http\Controllers\DashboardRedirectController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamLeader\AnalysisController;
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
    // Dashboard
    Route::get('dashboard', AdminDashboardController::class)->name('dashboard');

    // Roles & Permissions
    Route::get('roles', [RoleController::class, 'index'])->middleware('can:manage system')->name('roles.index');
    Route::get('roles/{role}', [RoleController::class, 'show'])->middleware('can:manage system')->name('roles.show');
    Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->middleware('can:manage system')->name('roles.edit');
    Route::patch('roles/{role}', [RoleController::class, 'update'])->middleware('can:manage system')->name('roles.update');

    // Technical Advisers
    Route::get('technical-advisers', [AdminTechnicalAdviserController::class, 'index'])->middleware('can:manage users')->name('technical-advisers.index');
    Route::get('technical-advisers/create', [AdminTechnicalAdviserController::class, 'create'])->middleware('can:manage users')->name('technical-advisers.create');
    Route::post('technical-advisers', [AdminTechnicalAdviserController::class, 'store'])->middleware('can:manage users')->name('technical-advisers.store');
    Route::get('technical-advisers/{user}', [AdminTechnicalAdviserController::class, 'show'])->middleware('can:manage users')->name('technical-advisers.show');
    Route::get('technical-advisers/{user}/edit', [AdminTechnicalAdviserController::class, 'edit'])->middleware('can:manage users')->name('technical-advisers.edit');
    Route::patch('technical-advisers/{user}', [AdminTechnicalAdviserController::class, 'update'])->middleware('can:manage users')->name('technical-advisers.update');
    Route::delete('technical-advisers/{user}', [AdminTechnicalAdviserController::class, 'destroy'])->middleware('can:manage users')->name('technical-advisers.destroy');

    // Capstone Teachers
    Route::get('capstone-teachers', [CapstoneTeacherController::class, 'index'])->middleware('can:manage users')->name('capstone-teachers.index');
    Route::get('capstone-teachers/create', [CapstoneTeacherController::class, 'create'])->middleware('can:manage users')->name('capstone-teachers.create');
    Route::post('capstone-teachers', [CapstoneTeacherController::class, 'store'])->middleware('can:manage users')->name('capstone-teachers.store');
    Route::get('capstone-teachers/{user}', [CapstoneTeacherController::class, 'show'])->middleware('can:manage users')->name('capstone-teachers.show');
    Route::get('capstone-teachers/{user}/edit', [CapstoneTeacherController::class, 'edit'])->middleware('can:manage users')->name('capstone-teachers.edit');
    Route::patch('capstone-teachers/{user}', [CapstoneTeacherController::class, 'update'])->middleware('can:manage users')->name('capstone-teachers.update');
    Route::delete('capstone-teachers/{user}', [CapstoneTeacherController::class, 'destroy'])->middleware('can:manage users')->name('capstone-teachers.destroy');
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

    // Analysis
    Route::get('team/analysis', [AnalysisController::class, 'show'])->name('analysis.show');
    Route::post('team/analysis/sync', [AnalysisController::class, 'syncAnalysis'])->name('analysis.sync');
    Route::post('team/documents', [AnalysisController::class, 'uploadDocument'])->name('analysis.upload-document');
    Route::delete('team/documents/{document}', [AnalysisController::class, 'deleteDocument'])->name('analysis.delete-document');
    Route::post('team/analysis/text', [AnalysisController::class, 'saveText'])->name('analysis.save-text');
    Route::delete('team/analysis/text', [AnalysisController::class, 'deleteText'])->name('analysis.delete-text');
    Route::post('team/analysis/generate', [AnalysisController::class, 'generate'])->name('analysis.generate');
    Route::post('team/analysis/approve-all', [AnalysisController::class, 'approveAll'])->name('analysis.approve-all');
    Route::post('team/stories', [AnalysisController::class, 'storeStory'])->name('analysis.store-story');
    Route::patch('team/stories/{story}', [AnalysisController::class, 'updateStory'])->name('analysis.update-story');
    Route::post('team/stories/{story}/approve', [AnalysisController::class, 'approveStory'])->name('analysis.approve-story');
    Route::patch('team/stories/{story}/achievement', [AnalysisController::class, 'toggleAchievementStatus'])->name('analysis.toggle-achievement');
    Route::delete('team/stories/{story}', [AnalysisController::class, 'deleteStory'])->name('analysis.delete-story');
});

// Capstone Teacher Routes
Route::middleware(['auth', 'verified', 'role:capstone_teacher'])->prefix('capstone-teacher')->name('capstone-teacher.')->group(function () {
    // Dashboard
    Route::get('dashboard', CapstoneTeacherDashboardController::class)->middleware('can:view dashboard')->name('dashboard');

    // Teams
    Route::get('teams', [CapstoneTeacherTeamController::class, 'index'])->middleware('can:view team progress')->name('teams.index');
    Route::get('teams/{team}', [CapstoneTeacherTeamController::class, 'show'])->middleware('can:view team progress')->name('teams.show');

    // Technical Advisers
    Route::get('technical-advisers', [CapstoneTeacherTechnicalAdviserController::class, 'index'])->middleware('can:manage technical advisers')->name('technical-advisers.index');
    Route::get('technical-advisers/create', [CapstoneTeacherTechnicalAdviserController::class, 'create'])->middleware('can:manage technical advisers')->name('technical-advisers.create');
    Route::post('technical-advisers', [CapstoneTeacherTechnicalAdviserController::class, 'store'])->middleware('can:manage technical advisers')->name('technical-advisers.store');
    Route::get('technical-advisers/{user}', [CapstoneTeacherTechnicalAdviserController::class, 'show'])->middleware('can:manage technical advisers')->name('technical-advisers.show');
    Route::get('technical-advisers/{user}/edit', [CapstoneTeacherTechnicalAdviserController::class, 'edit'])->middleware('can:manage technical advisers')->name('technical-advisers.edit');
    Route::patch('technical-advisers/{user}', [CapstoneTeacherTechnicalAdviserController::class, 'update'])->middleware('can:manage technical advisers')->name('technical-advisers.update');
    Route::delete('technical-advisers/{user}', [CapstoneTeacherTechnicalAdviserController::class, 'destroy'])->middleware('can:manage technical advisers')->name('technical-advisers.destroy');
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
        ->defaults('period', 'all')
        ->name('contributors');
});

require __DIR__.'/auth.php';
