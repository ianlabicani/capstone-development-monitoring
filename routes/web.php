<?php

use App\Http\Controllers\Admin\TechnicalAdviserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TechnicalAdviser\TeamLeaderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Technical Advisers
    Route::get('technical-advisers', [TechnicalAdviserController::class, 'index'])->middleware('can:manage users')->name('technical-advisers.index');
    Route::get('technical-advisers/create', [TechnicalAdviserController::class, 'create'])->middleware('can:manage users')->name('technical-advisers.create');
    Route::post('technical-advisers', [TechnicalAdviserController::class, 'store'])->middleware('can:manage users')->name('technical-advisers.store');
    Route::get('technical-advisers/{user}', [TechnicalAdviserController::class, 'show'])->middleware('can:manage users')->name('technical-advisers.show');
    Route::get('technical-advisers/{user}/edit', [TechnicalAdviserController::class, 'edit'])->middleware('can:manage users')->name('technical-advisers.edit');
    Route::patch('technical-advisers/{user}', [TechnicalAdviserController::class, 'update'])->middleware('can:manage users')->name('technical-advisers.update');
    Route::delete('technical-advisers/{user}', [TechnicalAdviserController::class, 'destroy'])->middleware('can:manage users')->name('technical-advisers.destroy');
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
});

require __DIR__.'/auth.php';
