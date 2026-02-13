<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'employee_id' => 'nullable|string|unique:employees,employee_id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:employees,email',
            'address' => 'nullable|string',
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'job_grade' => 'nullable|integer',
            'employment_type' => 'required|in:regular,contractual,part_time,probationary',
            'date_hired' => 'nullable|date',
            'basic_salary' => 'required|numeric|min:0'
        ];
    }
}