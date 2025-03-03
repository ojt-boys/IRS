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
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
   
    Route::middleware(['auth'])->group(function () {
        Route::get('/incoming', function () {
            return Inertia::render('IncomingShoes');
        })->name('incoming');
    });
    Route::middleware(['auth'])->group(function () {
        Route::get('/ForChecking', function () {
            return Inertia::render('ForChecking');
        })->name('ForChecking');
    });
    Route::middleware(['auth'])->group(function () {
        Route::get('/Repairing', function () {
            return Inertia::render('Repairing');
        })->name('Repairing');
    });
    Route::middleware(['auth'])->group(function () {
        Route::get('/Failed', function () {
            return Inertia::render('Failed');
        })->name('Failed');
    });
    Route::middleware(['auth'])->group(function () {
        Route::get('/Refund', function () {
            return Inertia::render('Refund');
        })->name('Refund');
    });
    Route::middleware(['auth'])->group(function () {
        Route::get('/Completed', function () {
            return Inertia::render('Completed');
        })->name('Completed');
    });
    Route::middleware(['auth'])->group(function () {
        Route::get('/Payments', function () {
            return Inertia::render('Payments');
        })->name('Payments');
    });
    Route::middleware(['auth'])->group(function () {
        Route::get('/Account', function () {
            return Inertia::render('Account');
        })->name('Account');
    });
    
});

