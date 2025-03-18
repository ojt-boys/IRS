<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class BranchController extends Controller
{
    // Show branch dashboard
    public function branchDashboard()
    {
        // Sample data for dashboard
        return Inertia::render('Branch/branchDashboard');
    }

    // Show form to add new shoes to the branch
    public function branchAddshoes()
    {
        return Inertia::render('Branch/branchAddshoes');
    }

    // Show list of shipped shoes for the branch
    public function branchShippedshoes()
    {
        return Inertia::render('Branch/branchShippedshoes');
    }

    // Show list of items for return in the branch
    public function branchReturned()
    {
        return Inertia::render('Branch/branchReturned');
    }

    // Show completed branch tasks
    public function branchCompleted()
    {
        return Inertia::render('Branch/branchCompleted');
    }
}
