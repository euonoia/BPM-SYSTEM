<?php

namespace App\Http\Controllers\core1;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        return view('core1.reports.index');
    }
}

