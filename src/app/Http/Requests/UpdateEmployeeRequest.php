<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $employeeId = $this->route('id');

        return [
            'employee_id' => 'nullable|string|unique:employees,employee_id,' . $employeeId,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:employees,email,' . $employeeId,
            'address' => 'nullable|string',
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'job_grade' => 'nullable|integer',
            'employment_type' => 'required|in:regular,contractual,part_time,probationary,terminated',
            'date_hired' => 'nullable|date',
            'basic_salary' => 'required|numeric|min:0'
        ];
    }
}