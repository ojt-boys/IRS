<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class BranchController extends Controller
{

    // Show form to add new shoes to the branch
    public function Addshoes()
    {
        return Inertia::render('Branch/Addshoes');
    }

    // Show list of shipped shoes for the branch
    public function Shippedshoes()
    {
        return Inertia::render('Branch/Shippedshoes');
    }

   
}
