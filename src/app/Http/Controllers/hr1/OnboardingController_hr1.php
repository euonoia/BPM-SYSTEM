<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\hr1\OnboardingTask_hr1;
use Illuminate\Http\Request;

class OnboardingController_hr1 extends Controller
{
    public function index()
    {
        $tasks = OnboardingTask_hr1::all();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'category' => 'required|in:Pre-onboarding,Orientation,IT Setup,Training',
            'assigned_to' => 'required|in:admin,staff,candidate',
            'user_id' => 'nullable|exists:users_hr1,id',
        ]);

        $task = OnboardingTask_hr1::create($validated);
        return response()->json($task, 201);
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'completed' => 'required|boolean',
        ]);

        $task = OnboardingTask_hr1::findOrFail($id);
        $task->update(['completed' => $validated['completed']]);
        return response()->json($task);
    }
}

