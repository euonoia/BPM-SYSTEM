<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\hr1\JobPosting_hr1;
use App\Services\GeminiService_hr1;
use Illuminate\Http\Request;

class JobController_hr1 extends Controller
{
    public function index()
    {
        $jobs = JobPosting_hr1::where('status', 'Open')->latest()->get();
        return response()->json($jobs);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'type' => 'required|in:Full-time,Part-time,Contract',
        ]);

        $description = '';
        if (config('services.gemini.api_key')) {
            $gemini = app(\App\Services\GeminiService_hr1::class);
            $description = $gemini->generateJobDescription($validated['title'], $validated['department']);
        }

        $job = JobPosting_hr1::create([
            'title' => $validated['title'],
            'department' => $validated['department'],
            'location' => $request->input('location', 'Main Hospital'),
            'type' => $validated['type'],
            'status' => 'Open',
            'posted_date' => now(),
            'description' => $description,
        ]);

        return response()->json($job, 201);
    }

    public function destroy($id)
    {
        $job = JobPosting_hr1::findOrFail($id);
        $job->delete();
        return response()->json(['message' => 'Job deleted successfully']);
    }
}

