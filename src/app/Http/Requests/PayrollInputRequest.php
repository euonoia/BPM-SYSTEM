<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayrollInputRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'employee_id' => 'required|string|max:20',
            'employee_name' => 'required|string|max:100',
            'department' => 'required|string|max:50',
            'position' => 'required|string|max:50',
            'days_worked' => 'required|integer|min:0|max:31',
            'overtime_hours' => 'nullable|numeric|min:0|max:999',
            'night_diff_hours' => 'nullable|numeric|min:0|max:999',
            'leaves_taken' => 'nullable|integer|min:0|max:31',
            'late_minutes' => 'nullable|integer|min:0|max:1440',
            'absent_days' => 'nullable|integer|min:0|max:31',
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'Employee ID is required',
            'employee_name.required' => 'Employee name is required',
            'department.required' => 'Department is required',
            'position.required' => 'Position is required',
            'days_worked.required' => 'Days worked is required',
            'days_worked.min' => 'Days worked must be at least 0',
            'days_worked.max' => 'Days worked cannot exceed 31',
            'overtime_hours.numeric' => 'Overtime hours must be a valid number',
            'late_minutes.max' => 'Late minutes cannot exceed 1440 (24 hours)',
        ];
    }
}
