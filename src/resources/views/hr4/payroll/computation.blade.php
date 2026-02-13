@extends('layouts.hr4.app')

@section('title', 'Payroll Computation - HR4')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.index') }}">HR4</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.payroll.index') }}">Payroll</a></li>
            <li class="breadcrumb-item active">Computation</li>
        </ol>
    </nav>

    <h2>Step 3: Compute Payroll</h2>
    
    <div class="card">
        <div class="card-header bg-success text-white">Payroll Computation Result</div>
        <div class="card-body">
            <h4>Employee: {{ $data['employee_name'] }}</h4>
            <p>ID: {{ $data['employee_id'] }} | Department: {{ $data['department'] }}</p>
            
            <table class="table table-bordered">
                <tr>
                    <td>Basic Pay ({{ $data['days_worked'] }} days)</td>
                    <td class="text-end">₱{{ number_format($computation['basic_pay'], 2) }}</td>
                </tr>
                <tr>
                    <td>Overtime Pay ({{ $data['overtime_hours'] }} hrs)</td>
                    <td class="text-end">+ ₱{{ number_format($computation['overtime_pay'], 2) }}</td>
                </tr>
                <tr>
                    <td>Night Differential ({{ $data['night_diff_hours'] }} hrs)</td>
                    <td class="text-end">+ ₱{{ number_format($computation['night_diff_pay'], 2) }}</td>
                </tr>
                <tr class="table-warning">
                    <td>Late Deduction ({{ $data['late_minutes'] }} mins)</td>
                    <td class="text-end">- ₱{{ number_format($computation['late_deduction'], 2) }}</td>
                </tr>
                <tr class="table-warning">
                    <td>Absent Deduction ({{ $data['absent_days'] }} days)</td>
                    <td class="text-end">- ₱{{ number_format($computation['absent_deduction'], 2) }}</td>
                </tr>
                <tr class="table-success">
                    <th>NET PAY</th>
                    <th class="text-end">₱{{ number_format($computation['net_pay'], 2) }}</th>
                </tr>
            </table>
            
            <div class="mt-3">
                <form action="{{ route('hr.hr4.payroll.store') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">Save & View Payslip</button>
                </form>
                <a href="{{ route('hr.hr4.payroll.index') }}" class="btn btn-primary">Process Another</a>
                <button class="btn btn-outline-secondary" onclick="window.print()">Print Preview</button>
            </div>
        </div>
    </div>
</div>
@endsection