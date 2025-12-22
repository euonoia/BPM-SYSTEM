<?php

namespace App\Http\Controllers\Hr2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\hr2\EssRequest;

class EssController extends Controller
{
    public function index()
    {
        $employee = Auth::user();
        $requests = EssRequest::where('employee_id', $employee->employee_id)
                              ->orderBy('created_at', 'desc')
                              ->get();

        return view('hr2.ess', compact('requests'));
    }

    public function store(Request $request)
    {
        $employee = Auth::user();

        $request->validate([
            'type' => 'required|string',
            'details' => 'required|string',
        ]);

        EssRequest::create([
            'employee_id' => $employee->employee_id,
            'type' => $request->type,
            'details' => $request->details,
            'status' => 'pending',
        ]);

        return redirect()->route('hr2.ess')->with('message', 'Request submitted successfully.');
    }
}
