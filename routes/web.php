<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BranchController;
use App\Http\Middleware\RoleMiddleware;  // Import the middleware

// Welcome page route
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Inside authenticated middleware group
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Admin Routes with Role Middleware
    Route::prefix('admin')
        ->name('admin.')
        ->middleware(RoleMiddleware::class.':admin,super-admin')  // Apply middleware with roles
        ->group(function () {

        Route::get('/adminDashboard', [AdminController::class, 'adminDashboard'])
            ->name('adminDashboard');

        // Admin-specific routes
        $adminRoutes = [
            'Incoming',
            'Assessment',
            'Joborder',
            'Returned',
            'Completed',
            'Payments',
            'Users',
            'Addshoes',
            'Shippedshoes',
        ];

        foreach ($adminRoutes as $route) {
            Route::get("/$route", [AdminController::class, $route])->name($route);

        }
    });

    // Branch Routes with Role Middleware
    Route::prefix('branch')
        ->name('branch.')
        ->middleware(RoleMiddleware::class.':branch,super-admin')  // Apply middleware with roles
        ->group(function () {

        $branchRoutes = [
            'Addshoes',
            'Shippedshoes',
        ];

        foreach ($branchRoutes as $route) {
            Route::get("/$route", [BranchController::class, $route])->name($route);
        }
    });

});
