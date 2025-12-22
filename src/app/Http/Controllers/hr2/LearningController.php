<?php

namespace App\Http\Controllers\Hr2;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\hr2\Course;
use App\Models\hr2\CourseEnroll;

class LearningController extends Controller
{
    public function index()
    {
        $employee = Auth::user();

        $courses = Course::withCount(['enrolls' => fn($q) => $q->where('employee_id', $employee->employee_id)])
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('hr2.learning', compact('courses'));
    }

    public function enroll(Course $course)
    {
        $employee = Auth::user();

        CourseEnroll::firstOrCreate([
            'employee_id' => $employee->employee_id,
            'course_id'   => $course->id,
        ]);

        return back()->with('success', 'You have successfully enrolled in this course.');
    }
}

