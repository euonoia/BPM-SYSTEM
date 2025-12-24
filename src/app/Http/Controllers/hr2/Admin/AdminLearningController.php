<?php

namespace App\Http\Controllers\Hr2\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hr2\Admin\LearningModuleHr2;

class AdminLearningController extends Controller
{
    public function index()
    {
        // Fetch all courses with enroll count, ordered by ID DESC
        $courses = LearningModuleHr2::withCount('enrolls')
            ->orderBy('id', 'desc')
            ->get();

        return view('hr2.admin.learning', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
            'competency_id' => 'nullable|integer',
            'learning_type' => 'nullable|in:Online,Workshop,Seminar,Coaching',
            'duration' => 'nullable|string|max:50',
        ]);

        LearningModuleHr2::create([
            'title' => $request->title,
            'description' => $request->description,
            'competency_id' => $request->competency_id,
            'learning_type' => $request->learning_type ?? 'Online',
            'duration' => $request->duration,
        ]);

        return redirect()->route('admin.learning')->with('success', 'Learning module added successfully.');
    }

    public function destroy($id)
    {
        $course = LearningModuleHr2::findOrFail($id);

        // Archive logic can be added here if needed
        $course->delete();

        return redirect()->route('admin.learning')->with('success', 'Learning module deleted successfully.');
    }
}
