<?php

namespace App\Http\Controllers\hr2\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Authenticate;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Show Add Admin Form
    public function create()
    {
        return view('hr2.admin.add-admin');
    }

    // Store new Admin
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:employees_hr2,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Authenticate::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', 
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Admin added successfully!');
    }
}
