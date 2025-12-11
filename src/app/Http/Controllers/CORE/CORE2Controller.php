<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;

class Core2Controller extends Controller
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
