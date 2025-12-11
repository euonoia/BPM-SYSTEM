<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;

class HR1Controller extends Controller
{
    public function index() {
        return view('hr1.index');
    }

    public function policies() {
        return view('hr1.policies');
    }

    public function reports() {
        return view('hr1.reports');
    }
}
