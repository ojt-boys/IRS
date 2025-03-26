<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class AdminController extends Controller
{
    public function Dashboard()
    {
        return Inertia::render('Admin/Dashboard');
    }

    public function Incoming()
    {
        return Inertia::render('Admin/Incoming');
    }

    public function Assessment()
    {
        return Inertia::render('Admin/Assessment');
    }

    public function Joborder()
    {
        return Inertia::render('Admin/Joborder');
    }

    public function Returned()
    {
        return Inertia::render('Admin/Returned');
    }

    public function Completed()
    {
        return Inertia::render('Admin/Completed');
    }

    public function Payments()
    {
        return Inertia::render('Admin/Payments');
    }

    public function Branch()
    {
        return Inertia::render('Admin/Branch');
    }

    public function Addshoes()
    {
        return Inertia::render('Admin/Addshoes');
    }

    public function Shippedshoes()
    {
        return Inertia::render('Admin/Shippedshoes');
    }
}
