<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePayrollRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'employee_id' => 'required|exists:employees,employee_id',
            'payroll_period' => 'required|string|max:50',
            'payroll_date' => 'nullable|date',
            'days_worked' => 'required|integer|min:0|max:31',
            'overtime_hours' => 'nullable|numeric|min:0',
            'night_diff_hours' => 'nullable|numeric|min:0',
            'leaves_taken' => 'nullable|integer|min:0',
            'late_minutes' => 'nullable|integer|min:0',
            'absent_days' => 'nullable|integer|min:0'
        ];
    }
}