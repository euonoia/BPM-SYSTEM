<?php

namespace App\Http\Controllers\Hr2;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\hr2\Course;
use App\Models\hr2\CourseEnroll;

class LearningController extends Controller
{
    // Display courses with employee's enrollment status
    public function index()
    {
        $employee = Auth::user();

        $courses = Course::with([
            'enrolls' => function ($q) use ($employee) {
                $q->where('employee_id', $employee->employee_id);
            }
        ])
        ->orderBy('created_at', 'desc')
        ->get();

        return view('hr2.learning', compact('courses'));
    }

    // Enroll the authenticated employee in a course
    public function enroll(string $course_id)
    {
        $employee = Auth::user();

        $course = Course::where('course_id', $course_id)->firstOrFail();

        // Ensure status is set when creating a new enrollment
        CourseEnroll::firstOrCreate(
            [
                'employee_id' => $employee->employee_id,
                'course_id'   => $course->course_id,
            ],
            [
                'status' => 'enrolled'  // important to avoid MySQL error
            ]
        );

        return redirect()
            ->route('hr2.learning')
            ->with('success', 'Successfully enrolled.');
    }
}
