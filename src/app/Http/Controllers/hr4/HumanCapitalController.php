<?php

namespace App\Http\Controllers\hr4;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class HumanCapitalController extends Controller
{
    public function index() {
        return view('hr4.human-capital.index');
    }
    
    public function process() {
        return view('hr4.human-capital.process');
    }
    
    public function checkEmployee(Request $request) {
        $data = $request->all();
        $is_new = ($data['employee_type'] === 'new');
        session(['employee_data' => $data, 'is_new' => $is_new]);
        
        return view('hr4.human-capital.employee-form', [
            'is_new' => $is_new,
            'data' => $data
        ]);
    }
    
    public function save(Request $request) {
        $data = $request->all();
        $is_complete = !empty($data['employee_id']) 
                    && !empty($data['first_name'])
                    && !empty($data['department'])
                    && ($data['basic_salary'] ?? 0) > 0;
        
        session(['employee_record' => $data, 'is_complete' => $is_complete]);
        return redirect()->route('hr.hr4.human-capital.validate-record');
    }
    
    public function validateRecord() {
        $employee = session('employee_record');
        $is_complete = session('is_complete', false);
        
        if (!$employee) {
            return redirect()->route('hr.hr4.human-capital.process')
                           ->with('error', 'No data found.');
        }
        
        return view('hr4.human-capital.validation', [
            'employee' => $employee,
            'is_complete' => $is_complete
        ]);
    }
    
    public function edit() {
        $employee = session('employee_record');
        $is_new = session('is_new', true);
        
        return view('hr4.human-capital.employee-form', [
            'is_new' => $is_new,
            'data' => $employee ?? []
        ]);
    }

    public function confirmSave(Request $request) {
        $employee = session('employee_record');
        if (!$employee || !session('is_complete', false)) {
            return redirect()->route('hr.hr4.human-capital.process')
                ->with('error', 'No valid record to save.');
        }

        $emp = Employee::updateOrCreate(
            ['employee_id' => $employee['employee_id']],
            [
                'first_name' => $employee['first_name'],
                'last_name' => $employee['last_name'],
                'department' => $employee['department'],
                'position' => $employee['position'],
                'job_grade' => $employee['job_grade'] ?? 1,
                'employment_type' => $employee['employment_type'] ?? 'regular',
                'date_hired' => $employee['date_hired'] ?? now(),
                'basic_salary' => $employee['basic_salary'],
            ]
        );

        session()->forget(['employee_record', 'employee_data', 'is_complete', 'is_new']);

        return redirect()->route('hr.hr4.human-capital.records')
            ->with('success', 'Employee ' . $emp->full_name . ' saved successfully!');
    }
    
    public function records() {
        $employees = Employee::orderBy('created_at', 'desc')->paginate(20);
        return view('hr4.human-capital.records', compact('employees'));
    }
    
    public function recruitment() {
        return view('hr4.human-capital.recruitment');
    }
    
    public function leaveScheduling() {
        return view('hr4.human-capital.leave-scheduling');
    }
}