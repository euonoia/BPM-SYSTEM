@extends('layouts.hr4.app')

@section('title', isset($admin) && $admin->id ? 'Edit Admin' : 'Create Admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-3">{{ isset($admin) && $admin->id ? 'Edit Admin' : 'Create Admin' }}</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ isset($admin) && $admin->id ? route('hr.hr4.admin.admins.update', $admin->id) : route('hr.hr4.admin.admins.store') }}">
                @csrf
                @if(isset($admin) && $admin->id)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password {{ isset($admin) && $admin->id ? '(leave blank to keep)' : '' }}</label>
                    <input type="password" name="password" class="form-control" {{ isset($admin) && $admin->id ? '' : 'required' }}>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-control" required>
                        <option value="super_admin" {{ old('role', $admin->role ?? '') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                        <option value="hr_admin" {{ old('role', $admin->role ?? 'hr_admin') == 'hr_admin' ? 'selected' : '' }}>HR Admin</option>
                        <option value="finance_admin" {{ old('role', $admin->role ?? '') == 'finance_admin' ? 'selected' : '' }}>Finance Admin</option>
                    </select>
                </div>

                <button class="btn btn-primary">Save</button>
                <a href="{{ route('hr.hr4.admin.admins.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
