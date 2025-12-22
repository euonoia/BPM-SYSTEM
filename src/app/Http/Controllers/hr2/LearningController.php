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

        $courses = Course::with([
            'enrolls' => function ($q) use ($employee) {
                $q->where('employee_id', $employee->employee_id);
            }
        ])->get();

        return view('hr2.learning', compact('courses'));
    }

    public function enroll(string $course_id)
    {
        $employee = Auth::user();

        $course = Course::where('course_id', $course_id)->firstOrFail();

        CourseEnroll::firstOrCreate([
            'employee_id' => $employee->employee_id,
            'course_id'   => $course->course_id,
        ]);

        return redirect()
            ->route('hr2.learning')
            ->with('success', 'Successfully enrolled.');
    }
}
