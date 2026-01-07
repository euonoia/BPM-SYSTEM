<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Application_hr1;
use Illuminate\Http\Request;

class ApplicantController_hr1 extends Controller
{
    public function index()
    {
        $applicants = User::where('role', 'candidate')->with('applications_hr1')->get();
        return response()->json($applicants);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users_hr1',
            'password' => 'required|string|min:8',
            'position' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'position' => $validated['position'],
            'role' => 'candidate',
            'status' => 'Applied',
            'applied_date' => now(),
        ]);

        return response()->json($user->load('applications_hr1'), 201);
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Applied,Evaluation,Interviewing,Offer,Onboarding,Rejected',
        ]);

        $user = User::findOrFail($id);
        $user->update(['status' => $validated['status']]);

        return response()->json($user);
    }

    public function show($id)
    {
        $applicant = User::with('applications_hr1.jobPosting_hr1')->findOrFail($id);
        return response()->json($applicant);
    }
}

