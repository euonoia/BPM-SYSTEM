<?php

namespace App\Http\Controllers\Hr2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\hr2\EssRequest;
use App\Models\hr2\EssRequestArchive;

class EssController extends Controller
{
    public function index()
    {
        $employee = Auth::user();
        $employee_code = $employee->employee_id;

        // Fetch active requests
        $active = EssRequest::where('employee_id', $employee_code)
            ->get();

        // Fetch archived requests
        $archived = EssRequestArchive::where('employee_id', $employee_code)
            ->get();

        // Merge and sort by created_at descending
        $requests = $active->concat($archived)
            ->sortByDesc('created_at');

        return view('hr2.ess', compact('requests'));
    }

    public function store(Request $request)
    {
        $employee = Auth::user();
        $employee_code = $employee->employee_id;

        $request->validate([
            'type' => 'required|string|max:255',
            'details' => 'required|string|max:2000',
        ]);

        // Generate ESS ID
        $lastEss = EssRequest::select('ess_id')->orderBy('id', 'desc')->first();
        $lastNumber = $lastEss ? (int) preg_replace('/\D/', '', $lastEss->ess_id) : 0;
        $nextNumber = $lastNumber + 1;
        $ess_id = 'ESS' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        EssRequest::create([
            'ess_id' => $ess_id,
            'employee_id' => $employee_code,
            'type' => $request->type,
            'details' => $request->details,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('hr2.ess')->with('message', 'Request submitted successfully.');
    }
}
