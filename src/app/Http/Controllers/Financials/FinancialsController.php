<?php

namespace App\Http\Controllers\Financials;

use App\Http\Controllers\Controller;

class FinancialsController extends Controller
{
    public function index()
    {
        return view('financials.index');
    }

    public function reports()
    {
        return view('financials.reports');
    }

    public function budgets()
    {
        return view('financials.budgets');
    }
}
