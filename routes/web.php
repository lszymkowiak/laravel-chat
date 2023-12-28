<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', fn () => Inertia::render('Dashboard'))->name('dashboard');

    Route::controller(\App\Http\Controllers\ChatController::class)
        ->prefix('chat')
        ->name('chat.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('{interlocutor_id}/{before_id?}', 'show')->name('show');
            Route::put('/', 'store')->name('store');
            Route::delete('{interlocutor_id}', 'destroy')->name('destroy');
        });
});
