<?php

namespace App\Http\Controllers\hr2;

use App\Http\Controllers\Controller;

class HR2Controller extends Controller
{
    public function index() {
        return view('hr2.index');
    }

    public function policies() {
        return view('hr2.policies');
    }

    public function reports() {
        return view('hr2.reports');
    }
}
