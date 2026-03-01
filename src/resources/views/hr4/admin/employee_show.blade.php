@extends('layouts.hr4.app')

@section('title', 'Employee Details - HR4')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Employee Details</h2>

    <div class="card">
        <div class="card-body">
            <h4>{{ $employee->first_name }} {{ $employee->last_name }}</h4>
            <p><strong>Employee ID:</strong> {{ $employee->employee_id }}</p>
            <p><strong>Department:</strong> {{ $employee->department }}</p>
            <p><strong>Role:</strong> {{ ucfirst($employee->role ?? 'employee') }}</p>
            <p><strong>Position:</strong> {{ $employee->position }}</p>
            <p><strong>Status:</strong> {{ ucfirst($employee->status ?? $employee->employment_type ?? 'active') }}</p>
            <p><strong>Date Hired:</strong> {{ optional($employee->date_hired)->format('Y-m-d') }}</p>

            <a href="{{ route('hr.hr4.admin.employees') }}" class="btn btn-secondary">Back to list</a>
        </div>
    </div>
</div>
@endsection
