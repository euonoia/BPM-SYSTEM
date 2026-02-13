<?php

namespace App\Http\Controllers\hr4;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\CompensationAdjustment;
use Illuminate\Http\Request;

class CompensationController extends Controller
{
    public function index()
    {
        $adjustments = CompensationAdjustment::with('employee')
                                            ->orderBy('created_at', 'desc')
                                            ->paginate(10);
        return view('hr4.compensation.index', compact('adjustments'));
    }

    public function input()
    {
        return view('hr4.compensation.input');
    }

    public function validateData(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required|string',
            'employee_name' => 'required|string',
            'current_grade' => 'required|integer|min:1|max:10',
            'current_salary' => 'required|numeric|min:0',
            'proposed_grade' => 'nullable|integer|min:1|max:10',
            'years_in_position' => 'required|integer|min:0',
            'performance_rating' => 'required|integer|min:1|max:5',
            'kpi_achievement' => 'required|numeric|min:0|max:200',
            'attendance_score' => 'required|numeric|min:0|max:100',
            'special_achievements' => 'nullable|string'
        ]);

        $is_complete = !empty($data['employee_id'])
                    && !empty($data['current_grade'])
                    && $data['current_salary'] > 0
                    && !empty($data['performance_rating']);

        $employee = Employee::where('employee_id', $data['employee_id'])->first();

        session([
            'compensation_data' => $data,
            'compensation_employee' => $employee,
            'is_complete' => $is_complete
        ]);

        return view('hr4.compensation.validation', [
            'data' => $data,
            'is_complete' => $is_complete
        ]);
    }

    public function calculate()
    {
        $data = session('compensation_data');

        if (!$data) {
            return redirect()->route('hr.hr4.compensation.input')
                           ->with('error', 'No data found. Please start again.');
        }

        $current_salary = $data['current_salary'];
        $new_salary = $current_salary;

        $promotion_raise = 0;
        if (!empty($data['proposed_grade']) && $data['proposed_grade'] > $data['current_grade']) {
            $grade_diff = $data['proposed_grade'] - $data['current_grade'];
            $promotion_raise = $current_salary * (0.15 * $grade_diff);
            $new_salary += $promotion_raise;
        }

        $performance_bonus = 0;
        if ($data['performance_rating'] == 5) {
            $performance_bonus = $current_salary * 0.15;
        } elseif ($data['performance_rating'] >= 4) {
            $performance_bonus = $current_salary * 0.10;
        }
        $new_salary += $performance_bonus;

        $kpi_incentive = 0;
        if ($data['kpi_achievement'] >= 100) {
            $kpi_incentive = $current_salary * (($data['kpi_achievement'] - 100) / 1000);
        }
        $new_salary += $kpi_incentive;

        $longevity_bonus = 0;
        if ($data['years_in_position'] >= 5) {
            $longevity_bonus = $current_salary * 0.05;
        }
        $new_salary += $longevity_bonus;

        $adjustment = [
            'promotion_raise' => round($promotion_raise, 2),
            'performance_bonus' => round($performance_bonus, 2),
            'kpi_incentive' => round($kpi_incentive, 2),
            'longevity_bonus' => round($longevity_bonus, 2),
            'new_salary' => round($new_salary, 2),
            'total_increase' => round($new_salary - $current_salary, 2),
            'increase_percentage' => round((($new_salary - $current_salary) / $current_salary) * 100, 2)
        ];

        session(['compensation_calculation' => $adjustment]);

        return view('hr4.compensation.calculate', [
            'data' => $data,
            'adjustment' => $adjustment
        ]);
    }

    public function submit(Request $request)
    {
        $action = $request->input('action');
        $data = session('compensation_data');
        $calculation = session('compensation_calculation');

        if (!$data || !$calculation) {
            return redirect()->route('hr.hr4.compensation.input')
                           ->with('error', 'Session expired. Please start again.');
        }

        if ($action == 'approve') {
            $employee = Employee::where('employee_id', $data['employee_id'])->first();
            $employeeId = $employee ? $employee->id : null;

            $adjustment = CompensationAdjustment::create([
                'employee_id' => $employeeId,
                'current_grade' => $data['current_grade'],
                'current_salary' => $data['current_salary'],
                'proposed_grade' => $data['proposed_grade'] ?? $data['current_grade'],
                'proposed_salary' => $calculation['new_salary'],
                'performance_rating' => $data['performance_rating'],
                'kpi_achievement' => $data['kpi_achievement'],
                'attendance_score' => $data['attendance_score'],
                'special_achievements' => $data['special_achievements'] ?? null,
                'promotion_raise' => $calculation['promotion_raise'],
                'performance_bonus' => $calculation['performance_bonus'],
                'kpi_incentive' => $calculation['kpi_incentive'],
                'longevity_bonus' => $calculation['longevity_bonus'],
                'total_increase' => $calculation['total_increase'],
                'increase_percentage' => $calculation['increase_percentage'],
                'status' => 'pending'
            ]);

            session()->forget(['compensation_data', 'compensation_employee', 'compensation_calculation', 'is_complete']);

            return redirect()->route('hr.hr4.compensation.index')
                           ->with('success', 'Compensation adjustment submitted for approval!');
        } else {
            return redirect()->route('hr.hr4.compensation.input')
                           ->with('info', 'Please modify the compensation details.');
        }
    }

    public function jobGrading()
    {
        $employees = Employee::select('job_grade', 'position', 'department')
                            ->selectRaw('COUNT(*) as count, AVG(basic_salary) as avg_salary')
                            ->groupBy('job_grade', 'position', 'department')
                            ->get();
        return view('hr4.compensation.job-grading', compact('employees'));
    }

    public function performance()
    {
        $employees = Employee::with('compensationAdjustments')
                            ->paginate(10);
        return view('hr4.compensation.performance', compact('employees'));
    }

    public function review()
    {
        $pending = CompensationAdjustment::with('employee')
                                        ->where('status', 'pending')
                                        ->paginate(10);
        return view('hr4.compensation.review', compact('pending'));
    }
}