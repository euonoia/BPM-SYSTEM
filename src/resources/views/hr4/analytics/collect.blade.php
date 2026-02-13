@extends('layouts.hr4.app')

@section('title', 'Collect Data - HR4')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.index') }}">HR4</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.analytics.index') }}">Analytics</a></li>
            <li class="breadcrumb-item active">Collect Data</li>
        </ol>
    </nav>

    <h2>Step 1: Collect Data from Payroll & HR Modules</h2>

    <form action="{{ route('hr.hr4.analytics.analyze') }}" method="POST">
        @csrf
        
        <div class="row">
            <!-- Payroll Data -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">Payroll Data</div>
                    <div class="card-body">
                        <div class="form-check mb-2">
                            <input type="checkbox" name="payroll_data[]" value="total_payroll" class="form-check-input" checked>
                            <label class="form-check-label">Total Payroll Costs</label>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" name="payroll_data[]" value="overtime" class="form-check-input" checked>
                            <label class="form-check-label">Overtime Analysis</label>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" name="payroll_data[]" value="deductions" class="form-check-input" checked>
                            <label class="form-check-label">Deductions Summary</label>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" name="payroll_data[]" value="benefits" class="form-check-input" checked>
                            <label class="form-check-label">Benefits Costs</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- HR Data -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-success text-white">HR Data</div>
                    <div class="card-body">
                        <div class="form-check mb-2">
                            <input type="checkbox" name="hr_data[]" value="headcount" class="form-check-input" checked>
                            <label class="form-check-label">Employee Headcount</label>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" name="hr_data[]" value="turnover" class="form-check-input" checked>
                            <label class="form-check-label">Turnover Rates</label>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" name="hr_data[]" value="attendance" class="form-check-input" checked>
                            <label class="form-check-label">Attendance Records</label>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" name="hr_data[]" value="performance" class="form-check-input" checked>
                            <label class="form-check-label">Performance Ratings</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Date Range -->
        <div class="card mb-3">
            <div class="card-header">Analysis Period</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label>From Date</label>
                        <input type="date" name="date_from" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>To Date</label>
                        <input type="date" name="date_to" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-lg">
            <i class="bi bi-bar-chart"></i> Analyze Data
        </button>
        <a href="{{ route('hr.hr4.analytics.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection