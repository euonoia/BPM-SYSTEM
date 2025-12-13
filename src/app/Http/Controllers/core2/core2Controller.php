<?php

namespace App\Http\Controllers\core2;

use App\Http\Controllers\Controller;

class core2Controller extends Controller
{
    public function index()
    {
        return view('core2.index'); 
    }

    
    public function policies()
    {
        return view('core2.policies'); 
    }


    public function reports()
    {
        return view('core2.reports'); 
    }
}
