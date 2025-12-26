<?php

namespace App\Http\Controllers\core1\Nurse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NurseDashboardController extends Controller
{
    public function index()
    {
        return view('core1.nurse.dashboard');
    }

    public function overview()
    {
        return view('core1.nurse.overview');
    }
}

