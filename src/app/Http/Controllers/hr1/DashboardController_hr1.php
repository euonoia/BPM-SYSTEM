<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JobPosting_hr1;
use App\Models\Application_hr1;
use App\Models\Recognition_hr1;
use App\Models\OnboardingTask_hr1;
use App\Models\EvaluationCriterion_hr1;
use App\Models\AwardCategory_hr1;
use App\Models\LearningModule_hr1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController_hr1 extends Controller
{
    public function index(Request $request)
    {
        // Get role from authenticated user, fallback to 'admin' if not authenticated
        $user = Auth::user();
        $role = $user ? $user->role : 'admin';
        $tab = $request->get('tab', 'dashboard');

        // Validate role
        if (!in_array($role, ['admin', 'staff', 'candidate'])) {
            $role = 'admin';
        }

        $data = [
            'role' => $role,
            'activeTab' => $tab,
            'applicants' => User::where('role', 'candidate')->with('applications_hr1')->get(),
            'jobs' => JobPosting_hr1::where('status', 'Open')->with('applications_hr1')->get(),
            'recognitions' => Recognition_hr1::latest()->get(),
            'tasks' => OnboardingTask_hr1::all(),
            'awardCategories' => AwardCategory_hr1::all(),
            'evalCriteria' => EvaluationCriterion_hr1::all(),
            'availableModules' => LearningModule_hr1::all(),
        ];

        // Return role-specific dashboard view
        return view("user_hr1.{$role}.dashboard", $data);
    }
}

