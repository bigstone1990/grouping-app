<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\GroupingController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'verified'])->name('top');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('groupings', [GroupingController::class, 'index'])->name('groupings.index');
    Route::get('groupings/create', [GroupingController::class, 'create'])->name('groupings.create');
    Route::post('groupings', [GroupingController::class, 'store'])->name('groupings.store');
    Route::get('groupings/{user_id}/{date}', [GroupingController::class, 'show'])->name('groupings.show');
    Route::get('groupings/{user_id}/{date}/edit', [GroupingController::class, 'edit'])->name('groupings.edit');
    Route::match(['put', 'patch'], 'groupings/{user_id}/{date}', [GroupingController::class, 'update'])->name('groupings.update');
    Route::delete('groupings/{user_id}/{date}', [GroupingController::class, 'destroy'])->name('groupings.destroy');
    Route::get('groupings/past', [GroupingController::class, 'past'])->name('groupings.past');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('groups/ordering/edit', [GroupController::class, 'orderingEdit'])->name('groups.ordering.edit');
    Route::patch('groups/ordering/update', [GroupController::class, 'orderingUpdate'])->name('groups.ordering.update');
    Route::resource('groups', GroupController::class);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('members', MemberController::class);
});

Route::middleware(['auth', 'verified','can:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
