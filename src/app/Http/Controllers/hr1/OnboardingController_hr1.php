<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\hr1\OnboardingTask_hr1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function taskSets()
    {
        $taskSets = DB::table('task_sets_hr1')
            ->leftJoin('tasks_hr1', 'task_sets_hr1.id', '=', 'tasks_hr1.task_set_id')
            ->select('task_sets_hr1.*')
            ->groupBy('task_sets_hr1.id')
            ->get()
            ->map(function($ts) {
                $ts->tasks = DB::table('tasks_hr1')->where('task_set_id', $ts->id)->get();
                return $ts;
            });
        return response()->json($taskSets);
    }

    public function storeTaskSet(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $taskSet = DB::table('task_sets_hr1')->insertGetId([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'created_by' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $taskSetData = DB::table('task_sets_hr1')->where('id', $taskSet)->first();
        $taskSetData->tasks = [];
        
        return response()->json($taskSetData, 201);
    }

    public function updateTaskSet(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
        ]);

        DB::table('task_sets_hr1')
            ->where('id', $id)
            ->update(array_merge($validated, ['updated_at' => now()]));

        $taskSet = DB::table('task_sets_hr1')->where('id', $id)->first();
        $taskSet->tasks = DB::table('tasks_hr1')->where('task_set_id', $id)->get();
        
        return response()->json($taskSet);
    }

    public function destroyTaskSet($id)
    {
        DB::table('task_sets_hr1')->where('id', $id)->delete();
        return response()->json(['message' => 'Task set deleted successfully']);
    }
}

