<?php

namespace App\Http\Controllers\core1;

use App\Http\Controllers\Controller;
use App\Models\core1\User;
use Illuminate\Http\Request;

class StaffManagementController extends Controller
{
    public function index()
    {
        $staff = User::whereIn('role', ['doctor', 'nurse', 'receptionist', 'billing'])
            ->latest()
            ->paginate(20);
        
        return view('core1.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('core1.staff.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:doctor,nurse,receptionist,billing',
            'department' => 'nullable|string',
            'specialization' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        $validated['password'] = bcrypt('password');
        $validated['status'] = 'active';
        $validated['employee_id'] = strtoupper(substr($validated['role'], 0, 3)) . str_pad(User::where('role', $validated['role'])->count() + 1, 3, '0', STR_PAD_LEFT);

        User::create($validated);

        return redirect()->route('staff.index')->with('success', 'Staff member added successfully.');
    }
}

