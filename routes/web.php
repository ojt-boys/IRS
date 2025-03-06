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



    Route::get('/admin/adminDashboard', function () {
        return Inertia::render('Admin/adminDashboard'); 
    })->name('admin.dashboard');

    Route::get('/admin/adminIncoming', function () {
        return Inertia::render('Admin/adminIncoming'); 
    })->name('admin.Incoming');

    Route::get('/admin/adminForchecking', function () {
        return Inertia::render('Admin/adminForchecking'); 
    })->name('admin.adminForchecking');

    Route::get('/admin/adminStatusrepairing', function () {
        return Inertia::render('Admin/adminStatusrepairing'); 
    })->name('admin.adminStatusrepairing');

    Route::get('/admin/adminStatusfailed', function () {
        return Inertia::render('Admin/adminStatusfailed'); 
    })->name('admin.adminStatusfailed');


    Route::get('/admin/adminRefund', function () {
        return Inertia::render('Admin/adminRefund'); 
    })->name('admin.adminRefund');


    Route::get('/admin/adminForreturn', function () {
        return Inertia::render('Admin/adminForreturn'); 
    })->name('admin.adminForreturn');



    Route::get('/admin/adminCompleted', function () {
        return Inertia::render('Admin/adminCompleted'); 
    })->name('admin.adminCompleted');

    Route::get('/admin/adminPayments', function () {
        return Inertia::render('Admin/adminPayments'); 
    })->name('admin.adminPayments');

    Route::get('/admin/adminBranch', function () {
        return Inertia::render('Admin/adminBranch'); 
    })->name('admin.adminBranch');
  

});
