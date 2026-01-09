<?php

namespace App\Http\Controllers\core1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InpatientController extends Controller
{
    public function index()
    {
        $stats = [
            'total_patients' => \App\Models\core1\Patient::count(),
            'admissions_today' => 0, // Placeholder for future admission logic
            'available_beds' => 24, // Static placeholder
            'on_waiting_list' => \App\Models\core1\WaitingList::where('status', 'pending')->count(),
        ];

        $waitingList = \App\Models\core1\WaitingList::with(['patient', 'doctor'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('core1.inpatient.index', compact('stats', 'waitingList'));
    }
}

