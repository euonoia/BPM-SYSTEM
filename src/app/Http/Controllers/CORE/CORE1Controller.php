<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;

class Core1Controller extends Controller
{
    public function index()
    {
        return view('core1.index'); 
    }

    // Show policies page for Core1
    public function policies()
    {
        return view('core1.policies'); 
    }

    // Show reports page for Core1
    public function reports()
    {
        return view('core1.reports'); 
    }
}
