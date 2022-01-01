<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['guest'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Auth\SignInController::class, 'view']);
    Route::get('/sign-in', [\App\Http\Controllers\Auth\SignInController::class, 'view'])->name('sign-in.view');
    Route::post('/sign-in', [\App\Http\Controllers\Auth\SignInController::class, 'action'])->name('sign-in.action');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/sign-out', [\App\Http\Controllers\Auth\SignOutController::class, 'action'])->name('sign-out.action');

    Route::get('/profile', [\App\Http\Controllers\Web\ProfileController::class, 'view'])
        ->name('profile');

    Route::post('/profile/change-password', [\App\Http\Controllers\Web\ProfileController::class, 'changePassword'])
        ->name('profile.change-password');

    Route::get('/dashboard/exercises', [\App\Http\Controllers\Web\DashboardController::class, 'exercises'])
        ->name('dashboard.exercises');

    Route::resource('/exercises', \App\Http\Controllers\Web\ExerciseController::class)
        ->only('show', 'edit', 'update', 'destroy');

    Route::patch('/exercises/{exercise}/restore', [\App\Http\Controllers\Web\ExerciseController::class, 'restore'])
        ->name('exercises.restore');

    Route::resource('/exercises/{exercise}/workouts', \App\Http\Controllers\Web\WorkoutController::class)
        ->only('create', 'store', 'edit', 'update', 'destroy');

    Route::patch('/exercises/{exercise}/workouts/{workout}/restore', [\App\Http\Controllers\Web\WorkoutController::class, 'restore'])
        ->name('workouts.restore');
});
