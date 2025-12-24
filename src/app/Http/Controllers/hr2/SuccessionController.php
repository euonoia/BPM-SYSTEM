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
        $employeeCode = $employee->employee_id;

        $positions = SuccessorCandidate::query()
            ->join(
                'succession_positions_hr2 as p',
                'p.branch_id',
                '=',
                'successor_candidates_hr2.branch_id'
            )
            ->where('successor_candidates_hr2.employee_id', $employeeCode)
            ->orderBy('p.position_title')
            ->select([
                'successor_candidates_hr2.*',
                'p.position_title',
                'p.criticality',
                'p.branch_id',
            ])
            ->get();

        return view('hr2.succession', compact('positions'));
    }
}
