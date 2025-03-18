<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BranchController;

// Welcome page route
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Inside authenticated middleware group for both admin and branch routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/adminDashboard', [AdminController::class, 'adminDashboard'])->name('adminDashboard'); // Admin Dashboard route

        // Admin specific routes
        $adminRoutes = [
            'adminIncoming',
            'adminAssessment',
            'adminJoborder',
            'adminReturned',
            'adminCompleted',
            'adminPayments',
            'adminBranch',
        ];

        foreach ($adminRoutes as $route) {
            Route::get("/$route", [AdminController::class, $route])->name("admin.$route");
        }
    });

    // Branch routes
    Route::prefix('branch')->name('branch.')->group(function () {
        $branchRoutes = [
            'branchDashboard',
            'branchAddshoes',
            'branchShippedshoes',
            'branchReturned',
            'branchCompleted',
        ];

    Route::get('/admin/adminForchecking', function () {
        return Inertia::render('Admin/adminForchecking'); 
    })->name('admin.adminForchecking');

    Route::get('/admin/adminStatus', function () {
        return Inertia::render('Admin/adminStatus'); 
    })->name('admin.adminStatus');


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



