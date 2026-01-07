<?php

namespace App\Http\Controllers\Hr2;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\hr2\Competency;
use App\Models\hr2\CourseEnroll;
use App\Models\hr2\TrainingEnroll;
use App\Models\hr2\EssRequest;

class DashboardController extends Controller
{
    public function index()
    {
        // Get logged-in employee
        $employee = Auth::user();

        // Dashboard counts
        $counts = [
            'Competencies' => Competency::count(),
            'Courses'      => CourseEnroll::where('employee_id', $employee->employee_id)->count(),
            'Trainings'    => TrainingEnroll::where('employee_id', $employee->employee_id)->count(),
            'ESS Requests' => EssRequest::where('employee_id', $employee->employee_id)->count(),
        ];

        // Pass variables to view
        return view('hr2.index', compact('employee', 'counts'));
    }
}

