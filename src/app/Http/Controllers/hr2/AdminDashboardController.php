<?php

namespace App\Http\Controllers\Hr2;

use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('hr2.admin.dashboard');
    }
}
