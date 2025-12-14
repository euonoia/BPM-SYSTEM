<?php

namespace App\Http\Controllers\hr3;

use App\Http\Controllers\Controller;

class HR3Controller extends Controller
{
    public function index() {
        return view('hr3.index');
    }

    public function policies() {
        return view('hr3.policies');
    }

    public function reports() {
        return view('hr3.reports');
    }
}
