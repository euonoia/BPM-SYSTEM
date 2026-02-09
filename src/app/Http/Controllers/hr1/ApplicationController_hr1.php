<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\hr1\Application_hr1;
use App\Models\hr1\JobPosting_hr1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApplicationController_hr1 extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_id' => 'required|exists:job_postings_hr1,id',
            'documents' => 'nullable|array',
            'documents.*' => 'file|max:10240',
        ]);

        $documents = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $documents[] = $file->store('applications_hr1', 'public');
            }
        }

        $application = Application_hr1::create([
            'user_id' => Auth::id(),
            'job_posting_id' => $validated['job_id'],
            'status' => 'Applied',
            'applied_date' => now(),
            'documents' => $documents,
        ]);

        return response()->json($application, 201);
    }

    public function scheduleInterview(Request $request, $id)
    {
        $validated = $request->validate([
            'interview_date' => 'required|date',
            'interview_location' => 'required|string|max:255',
            'interview_description' => 'nullable|string',
        ]);

        $application = Application_hr1::findOrFail($id);
        $application->update([
            'interview_date' => $validated['interview_date'],
            'interview_location' => $validated['interview_location'],
            'interview_description' => $validated['interview_description'] ?? '',
            'status' => 'Interviewing',
        ]);

        $application->user->update(['status' => 'Interviewing']);

        return response()->json($application);
    }
}

