<?php

namespace App\Http\Controllers\Logistics1;

use App\Http\Controllers\Controller;

class Logistics1Controller extends Controller
{
    public function index()
    {
        return view('logistics1.index');
    }

    public function policies()
    {
        return view('logistics1.policies');
    }

    public function reports()
    {
        return view('logistics1.reports');
    }
}
