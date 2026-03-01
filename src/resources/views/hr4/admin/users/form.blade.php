@extends('layouts.hr4.app')

@section('title', isset($user) && $user->id ? 'Edit HR User' : 'Create HR User')

@section('content')
<div class="container-fluid">
    <div style="margin-bottom: 30px;">
        <h2 style="margin: 0 0 10px 0;">{{ isset($user) && $user->id ? 'Edit HR User' : 'Create New HR User' }}</h2>
        <p class="text-muted" style="margin: 0;">{{ isset($user) && $user->id ? 'Update HR staff or head account details' : 'Create a new HR staff or HR head account' }}</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-circle"></i>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <i class="bi bi-person-plus"></i> HR User Details
        </div>
        <div class="card-body">
            <form method="POST" action="{{ isset($user) && $user->id ? route('hr.hr4.admin.users.update', $user->id) : route('hr.hr4.admin.users.store') }}">
                @csrf
                @if(isset($user) && $user->id)
                    @method('PUT')
                @endif

                <!-- Personal Information Section -->
                <div style="margin-bottom: 30px;">
                    <h5 style="color: #0F4C75; margin-bottom: 20px; border-bottom: 2px solid #E1E8ED; padding-bottom: 10px;">
                        <i class="bi bi-person"></i> Personal Information
                    </h5>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label"><i class="bi bi-hash"></i> Employee ID</label>
                            <input type="text" name="employee_id" class="form-control" value="{{ old('employee_id', $user->employee_id ?? '') }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label"><i class="bi bi-person-fill"></i> First Name</label>
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $user->first_name ?? '') }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label"><i class="bi bi-person-fill"></i> Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $user->last_name ?? '') }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label"><i class="bi bi-envelope"></i> Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
                        </div>
                    </div>
                </div>

                <!-- Account Security Section -->
                <div style="margin-bottom: 30px;">
                    <h5 style="color: #0F4C75; margin-bottom: 20px; border-bottom: 2px solid #E1E8ED; padding-bottom: 10px;">
                        <i class="bi bi-lock"></i> Account Security
                    </h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Password {{ isset($user) && $user->id ? '<small>(leave blank to keep current password)</small>' : '' }}</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password" {{ isset($user) && $user->id ? '' : 'required' }}>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
                        </div>
                    </div>
                </div>

                <!-- Role & Department Section -->
                <div style="margin-bottom: 30px;">
                    <h5 style="color: #0F4C75; margin-bottom: 20px; border-bottom: 2px solid #E1E8ED; padding-bottom: 10px;">
                        <i class="bi bi-briefcase"></i> Role & Department
                    </h5>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label"><i class="bi bi-shield-check"></i> Role</label>
                            <select name="role" class="form-control" required>
                                <option value="">-- Select Role --</option>
                                <option value="hr_staff" {{ old('role', $user->role ?? '') == 'hr_staff' ? 'selected' : '' }}>HR Staff</option>
                                <option value="hr_head" {{ old('role', $user->role ?? '') == 'hr_head' ? 'selected' : '' }}>HR Head</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label"><i class="bi bi-building"></i> Department</label>
                            <input type="text" name="department" class="form-control" value="{{ old('department', $user->department ?? '') }}" placeholder="e.g., Human Resources" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label"><i class="bi bi-briefcase-fill"></i> Position</label>
                            <input type="text" name="position" class="form-control" value="{{ old('position', $user->position ?? '') }}" placeholder="e.g., HR Manager" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label"><i class="bi bi-cash-coin"></i> Basic Salary</label>
                            <input type="number" name="basic_salary" class="form-control" value="{{ old('basic_salary', $user->basic_salary ?? '') }}" step="0.01" placeholder="0.00" required>
                        </div>
                    </div>
                </div>

                <!-- Employment Details Section -->
                <div style="margin-bottom: 30px;">
                    <h5 style="color: #0F4C75; margin-bottom: 20px; border-bottom: 2px solid #E1E8ED; padding-bottom: 10px;">
                        <i class="bi bi-calendar-event"></i> Employment Details
                    </h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label"><i class="bi bi-calendar"></i> Date Hired</label>
                            <input type="date" name="date_hired" class="form-control" value="{{ old('date_hired', optional($user->date_hired)->format('Y-m-d') ?? '') }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label"><i class="bi bi-toggle-on"></i> Status</label>
                            <select name="status" class="form-control" required>
                                <option value="active" {{ old('status', $user->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="terminated" {{ old('status', $user->status) == 'terminated' ? 'selected' : '' }}>Terminated</option>
                                <option value="on_leave" {{ old('status', $user->status) == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                    <a href="{{ route('hr.hr4.admin.users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> {{ isset($user) && $user->id ? 'Update User' : 'Create User' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
