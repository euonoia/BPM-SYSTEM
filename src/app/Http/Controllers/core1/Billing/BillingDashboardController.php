<?php

namespace App\Http\Controllers\core1\Billing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\core1\Bill;

class BillingDashboardController extends Controller
{
    public function index()
    {
        $todayRevenue = Bill::whereDate('bill_date', today())
            ->where('status', 'paid')
            ->sum('total');
        
        $pendingBills = Bill::where('status', 'pending')->count();

        return view('core1.billing.dashboard', compact('todayRevenue', 'pendingBills'));
    }

    public function overview()
    {
        $todayRevenue = Bill::whereDate('bill_date', today())
            ->where('status', 'paid')
            ->sum('total');
        
        $pendingBills = Bill::where('status', 'pending')->count();

        return view('core1.billing.overview', compact('todayRevenue', 'pendingBills'));
    }
}

