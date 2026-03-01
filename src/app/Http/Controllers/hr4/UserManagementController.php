<?php

namespace App\Http\Controllers\hr4;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = Employee::whereIn('role', ['hr_staff','hr_head'])->paginate(15);
        return view('hr4.admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('hr4.admin.users.form', ['user' => new Employee()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|string|unique:employees,employee_id',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'nullable|email|unique:employees,email',
            'role' => 'required|in:hr_staff,hr_head',
            'department' => 'required|string|max:50',
            'position' => 'required|string|max:100',
            'basic_salary' => 'required|numeric|min:0',
            'date_hired' => 'required|date',
            'status' => 'required|in:active,inactive,terminated,on_leave',
            'password' => 'nullable|min:8|confirmed'
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        Employee::create($validated);

        return redirect()->route('hr.hr4.admin.users.index')
                        ->with('success', 'Employee user created successfully!');
    }

    public function edit($id)
    {
        $user = Employee::findOrFail($id);
        return view('hr4.admin.users.form', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = Employee::findOrFail($id);

        $validated = $request->validate([
            'employee_id' => 'required|string|unique:employees,employee_id,' . $id,
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'nullable|email|unique:employees,email,' . $id,
            'role' => 'required|in:hr_staff,hr_head',
            'department' => 'required|string|max:50',
            'position' => 'required|string|max:100',
            'basic_salary' => 'required|numeric|min:0',
            'date_hired' => 'required|date',
            'status' => 'required|in:active,inactive,terminated,on_leave',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('hr.hr4.admin.users.index')
                        ->with('success', 'Employee user updated successfully!');
    }

    public function destroy($id)
    {
        $user = Employee::findOrFail($id);
        $user->delete();
        return redirect()->route('hr.hr4.admin.users.index')
                        ->with('success', 'Employee user deleted successfully!');
    }
}
