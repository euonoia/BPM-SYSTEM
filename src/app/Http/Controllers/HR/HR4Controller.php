<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;

class HR4Controller extends Controller
{
    public function index() {
        return view('hr4.index');
    }

    public function policies() {
        return view('hr4.policies');
    }

    public function reports() {
        return view('hr4.reports');
    }
}
