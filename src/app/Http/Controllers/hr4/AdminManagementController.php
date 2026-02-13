<?php

namespace App\Http\Controllers\hr4;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminManagementController extends Controller
{
    public function index()
    {
        $admins = Admin::paginate(10);
        return view('hr4.admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('hr4.admin.admins.form', ['admin' => new Admin()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:super_admin,hr_admin,finance_admin'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Admin::create($validated);

        return redirect()->route('hr.hr4.admin.admins.index')
                        ->with('success', 'Admin created successfully!');
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('hr4.admin.admins.form', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $id,
            'role' => 'required|in:super_admin,hr_admin,finance_admin'
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $validated['password'] = Hash::make($request->password);
        }

        $admin->update($validated);

        return redirect()->route('hr.hr4.admin.admins.index')
                        ->with('success', 'Admin updated successfully!');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);

        if ($admin->id === auth('admin')->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account!');
        }

        $admin->delete();

        return redirect()->route('hr.hr4.admin.admins.index')
                        ->with('success', 'Admin deleted successfully!');
    }
}