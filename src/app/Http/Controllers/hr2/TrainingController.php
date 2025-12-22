<?php

namespace App\Http\Controllers\Hr2;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\hr2\TrainingSession;
use App\Models\hr2\TrainingEnroll;

class TrainingController extends Controller
{
    public function index()
    {
        $employee = Auth::user();
        $sessions = TrainingSession::withCount(['enrolls' => fn($q) => $q->where('employee_id', $employee->employee_id)])
                                   ->orderBy('start_datetime', 'asc')
                                   ->get();

        return view('hr2.training', compact('sessions'));
    }

    public function enroll(TrainingSession $training)
    {
        $employee = Auth::user();
        TrainingEnroll::firstOrCreate([
            'employee_id' => $employee->employee_id,
            'training_id' => $training->training_id,
        ], [
            'status' => 'enrolled'
        ]);

        return redirect()->route('hr2.training')->with('message', 'Successfully enrolled!');
    }
}
