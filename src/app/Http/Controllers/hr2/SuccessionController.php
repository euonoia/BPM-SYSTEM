<?php

namespace App\Http\Controllers\Hr2;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\hr2\SuccessorCandidate;

class SuccessionController extends Controller
{
    public function index()
    {
        $employee = Auth::user();
        $positions = SuccessorCandidate::with('position')
                                        ->where('employee_id', $employee->employee_id)
                                        ->get();

        return view('hr2.succession', compact('positions'));
    }
}
