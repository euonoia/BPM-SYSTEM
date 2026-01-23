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

        // Calculate dynamic analytics
        $totalApplicants = User::where('role', 'candidate')->count();
        $totalJobs = JobPosting_hr1::where('status', 'Open')->count();
        $totalRecognitions = Recognition_hr1::count();
        $pendingTasks = OnboardingTask_hr1::where('completed', false)->count();
        
        // Calculate offer acceptance rate
        $offeredCount = Application_hr1::where('status', 'Offer')->count();
        $onboardingCount = Application_hr1::where('status', 'Onboarding')->count();
        $totalOffered = $offeredCount + $onboardingCount;
        $offerAcceptanceRate = $totalOffered > 0 ? round(($onboardingCount / $totalOffered) * 100) : 0;
        
        // Calculate average time to hire (days between applied_date and onboarding)
        $avgTimeToHire = Application_hr1::where('status', 'Onboarding')
            ->whereNotNull('applied_date')
            ->selectRaw('AVG(DATEDIFF(NOW(), applied_date)) as avg_days')
            ->value('avg_days') ?? 0;
        $avgTimeToHire = round($avgTimeToHire);
        
        // Calculate training compliance (completed learning modules / total assigned)
        $totalAssignedModules = \DB::table('user_learning_modules_hr1')->count();
        $completedModules = \DB::table('user_learning_modules_hr1')->where('completed', 1)->count();
        $trainingCompliance = $totalAssignedModules > 0 ? round(($completedModules / $totalAssignedModules) * 100) : 0;
        
        // Get onboarding candidates (status = Onboarding)
        $onboardingCandidates = User::where('role', 'candidate')
            ->where('status', 'Onboarding')
            ->with('applications_hr1')
            ->get();
        
        // Get task sets and question sets from database
        $taskSets = \DB::table('task_sets_hr1')
            ->leftJoin('tasks_hr1', 'task_sets_hr1.id', '=', 'tasks_hr1.task_set_id')
            ->select('task_sets_hr1.*', \DB::raw('GROUP_CONCAT(tasks_hr1.id) as task_ids'))
            ->groupBy('task_sets_hr1.id')
            ->get()
            ->map(function($ts) {
                $ts->tasks = \DB::table('tasks_hr1')->where('task_set_id', $ts->id)->get();
                return $ts;
            });
        
        $questionSets = \DB::table('question_sets_hr1')
            ->leftJoin('questions_hr1', 'question_sets_hr1.id', '=', 'questions_hr1.question_set_id')
            ->select('question_sets_hr1.*', \DB::raw('GROUP_CONCAT(questions_hr1.id) as question_ids'))
            ->groupBy('question_sets_hr1.id')
            ->get()
            ->map(function($qs) {
                $qs->questions = \DB::table('questions_hr1')->where('question_set_id', $qs->id)->get();
                return $qs;
            });
        
        // Get admin profile
        $adminProfile = User::where('role', 'admin')->first();

        $data = [
            'role' => $role,
            'activeTab' => $tab,
            'applicants' => User::where('role', 'candidate')->with('applications_hr1')->get(),
            'jobs' => JobPosting_hr1::where('status', 'Open')->with('applications_hr1.user')->get(),
            'recognitions' => Recognition_hr1::latest()->get(),
            'tasks' => OnboardingTask_hr1::all(),
            'awardCategories' => AwardCategory_hr1::all(),
            'evalCriteria' => EvaluationCriterion_hr1::all(),
            'availableModules' => LearningModule_hr1::all(),
            'taskSets' => $taskSets,
            'questionSets' => $questionSets,
            'onboardingCandidates' => $onboardingCandidates,
            'adminProfile' => $adminProfile,
            // Analytics
            'analytics' => [
                'totalApplicants' => $totalApplicants,
                'offerAcceptanceRate' => $offerAcceptanceRate,
                'avgTimeToHire' => $avgTimeToHire,
                'trainingCompliance' => $trainingCompliance,
                'totalJobs' => $totalJobs,
                'pendingTasks' => $pendingTasks,
                'totalRecognitions' => $totalRecognitions,
            ],
        ];

        // Return role-specific dashboard view
        return view("hr1.user_hr1.{$role}.dashboard", $data);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users_hr1,email,' . $user->id,
            'contact_no' => 'sometimes|string|max:20',
            'date_of_employment' => 'sometimes|date',
            'profile_picture' => 'sometimes|string', // For now, accept data URL
        ]);

        $user->update($validated);
        return response()->json($user);
    }
}

