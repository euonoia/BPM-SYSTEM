@extends('layouts.hr4.app')

@section('title', 'Payslip - HR4')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.index') }}">HR4</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.payroll.index') }}">Payroll</a></li>
            <li class="breadcrumb-item active">Payslip</li>
        </ol>
    </nav>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card" id="payslip">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <h4 class="mb-0">Payslip</h4>
            <span>{{ optional($payroll->payroll_date)->format('F Y') }}</span>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>{{ $payroll->employee ? $payroll->employee->first_name . ' ' . $payroll->employee->last_name : 'N/A' }}</h5>
                    <p class="mb-0">ID: {{ $payroll->employee->employee_id ?? 'N/A' }}</p>
                    <p class="mb-0">Department: {{ $payroll->employee->department ?? 'N/A' }}</p>
                    <p class="mb-0">Period: {{ $payroll->payroll_period ?? '-' }}</p>
                </div>
            </div>
            
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr><th>Earnings</th><th class="text-end">Amount</th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Basic Pay ({{ $payroll->days_worked ?? 0 }} days)</td>
                        <td class="text-end">₱{{ number_format($payroll->basic_pay ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Overtime Pay</td>
                        <td class="text-end">₱{{ number_format($payroll->overtime_pay ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Night Differential</td>
                        <td class="text-end">₱{{ number_format($payroll->night_diff_pay ?? 0, 2) }}</td>
                    </tr>
                    <tr class="table-light">
                        <th>Gross Pay</th>
                        <th class="text-end">₱{{ number_format($payroll->gross_pay ?? ($payroll->basic_pay + $payroll->overtime_pay + $payroll->night_diff_pay), 2) }}</th>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered">
                <thead class="table-light">
                    <tr><th>Deductions</th><th class="text-end">Amount</th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Late Deduction</td>
                        <td class="text-end">- ₱{{ number_format($payroll->late_deduction ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Absent Deduction</td>
                        <td class="text-end">- ₱{{ number_format($payroll->absent_deduction ?? 0, 2) }}</td>
                    </tr>
                    <tr class="table-success">
                        <th>NET PAY</th>
                        <th class="text-end">₱{{ number_format($payroll->net_pay ?? 0, 2) }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        <button onclick="window.print()" class="btn btn-primary">Print Payslip</button>
        <a href="{{ route('hr.hr4.payroll.index') }}" class="btn btn-secondary">Back to Payroll</a>
    </div>
</div>
@endsection
