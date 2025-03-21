<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class ShoeTechController extends Controller
{
    public function shoetechDashboard()
    {
        return Inertia::render('shoe/Dashboard'); 
    }

}
