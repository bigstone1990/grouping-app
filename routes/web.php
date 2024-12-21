<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\GroupingController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MemberController;
use App\Models\Group;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/grouping/index', [GroupingController::class, 'index'])->name('grouping.index');
});


Route::middleware('auth')->group(function () {
    Route::get('groups/ordering/edit', [GroupController::class, 'orderingEdit'])->name('groups.ordering.edit');
    Route::patch('groups/ordering/update', [GroupController::class, 'orderingUpdate'])->name('groups.ordering.update');
    Route::resource('groups', GroupController::class);
});

Route::middleware('auth')->group(function () {
    Route::resource('members', MemberController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
