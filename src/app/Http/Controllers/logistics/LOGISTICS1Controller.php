<?php

namespace App\Http\Controllers\Logistics;

use App\Http\Controllers\Controller;

class Logistics1Controller extends Controller
{
    
    public function index()
    {
        return view('logistics1.index'); 
    }

    // Show policies page for Logistics1
    public function policies()
    {
        return view('logistics1.policies'); 
    }

    // Show reports page for Logistics1
    public function reports()
    {
        return view('logistics1.reports'); 
    }
}
