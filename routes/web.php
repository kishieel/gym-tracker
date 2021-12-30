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
    Route::get('/', [\App\Http\Controllers\SignInController::class, 'view']);
    Route::get('/sign-in', [\App\Http\Controllers\SignInController::class, 'view'])->name('sign-in.view');
    Route::post('/sign-in', [\App\Http\Controllers\SignInController::class, 'action'])->name('sign-in.action');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/sign-out', [\App\Http\Controllers\SignOutController::class, 'action'])->name('sign-out.action');

    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'exercises']);
    Route::get('/dashboard/exercises', [\App\Http\Controllers\DashboardController::class, 'exercises'])
        ->name('dashboard.exercises');

    Route::resource('/exercises', \App\Http\Controllers\ExerciseController::class)
        ->only('show', 'create', 'store', 'edit', 'update', 'destroy');

    Route::resource('/exercises/{exercise}/repetitions', \App\Http\Controllers\RepetitionController::class)
        ->only('create', 'store', 'edit', 'update', 'destroy');

    Route::patch('/exercises/{exercise}/repetitions/{repetition}/restore', [\App\Http\Controllers\RepetitionController::class, 'restore'])
        ->name('repetitions.restore');
});
