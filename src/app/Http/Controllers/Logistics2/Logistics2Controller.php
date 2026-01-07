<?php

namespace App\Http\Controllers\Logistics2;

use App\Http\Controllers\Controller;

class Logistics2Controller extends Controller
{
    public function index()
    {
        return view('logistics2.index');
    }

    public function policies()
    {
        return view('logistics2.policies');
    }

    public function reports()
    {
        return view('logistics2.reports');
    }
}
