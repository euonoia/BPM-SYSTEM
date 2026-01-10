<?php

namespace App\Http\Controllers\hr1;

use App\Http\Controllers\Controller;
use App\Models\hr1\User;
use App\Models\hr1\JobPosting_hr1;
use App\Models\hr1\Application_hr1;
use App\Models\hr1\Recognition_hr1;
use App\Models\hr1\OnboardingTask_hr1;
use App\Models\hr1\EvaluationCriterion_hr1;
use App\Models\hr1\AwardCategory_hr1;
use App\Models\hr1\LearningModule_hr1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController_hr1 extends Controller
{
    public function index(Request $request)
    {
        // Get role from authenticated user, fallback to 'admin' if not authenticated
        $user = Auth::user();
        // Change FROM:
        $role = $request->get('role', $user ? $user->role : 'admin');
        
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
        return view("hr1.user_hr1.{$role}.dashboard", $data);
    }
}

