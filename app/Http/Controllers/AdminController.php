<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class AdminController extends Controller
{
    public function adminDashboard()
    {
        return Inertia::render('Admin/adminDashboard'); // Renders the 'Admin/adminDashboard' Vue component
    }

    public function adminIncoming()
    {
        return Inertia::render('Admin/adminIncoming'); // Renders the 'Admin/adminIncoming' Vue component
    }

    public function adminAssessment()
    {
        return Inertia::render('Admin/adminAssessment'); // Renders the 'Admin/adminAssessment' Vue component
    }

    public function adminJoborder()
    {
        return Inertia::render('Admin/adminJoborder'); // Renders the 'Admin/adminJoborder' Vue component
    }

    public function adminReturned()
    {
        return Inertia::render('Admin/adminReturned'); // Renders the 'Admin/adminReturned' Vue component
    }

    public function adminCompleted()
    {
        return Inertia::render('Admin/adminCompleted'); // Renders the 'Admin/adminCompleted' Vue component
    }

    public function adminPayments()
    {
        return Inertia::render('Admin/adminPayments'); // Renders the 'Admin/adminPayments' Vue component
    }

    public function adminBranch()
    {
        return Inertia::render('Admin/adminBranch'); // Renders the 'Admin/adminBranch' Vue component
    }
}
