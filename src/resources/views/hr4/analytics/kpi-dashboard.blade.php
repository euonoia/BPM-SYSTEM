@extends('layouts.hr4.app')

@section('title', 'KPI Dashboard - HR4')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.index') }}">HR4</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.analytics.index') }}">Analytics</a></li>
            <li class="breadcrumb-item active">KPI Dashboard</li>
        </ol>
    </nav>

    <h2>HR KPI Dashboard</h2>
    <p class="text-muted">Key Performance Indicators</p>
    
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white text-center">
                <div class="card-body">
                    <h3>{{ $latestReport ? number_format($latestReport->turnover_rate, 1) . '%' : '0%' }}</h3>
                    <p class="mb-0">Turnover Rate</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white text-center">
                <div class="card-body">
                    <h3>{{ $latestReport ? number_format($latestReport->avg_attendance_rate, 1) . '%' : '0%' }}</h3>
                    <p class="mb-0">Avg Attendance</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white text-center">
                <div class="card-body">
                    <h3>{{ $latestReport ? $latestReport->total_employees : 0 }}</h3>
                    <p class="mb-0">Total Employees</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-dark text-center">
                <div class="card-body">
                    <h3>₱{{ $latestReport ? number_format($latestReport->avg_cost_per_employee, 0) : '0' }}</h3>
                    <p class="mb-0">Cost/Employee</p>
                </div>
            </div>
        </div>
    </div>

    @if($latestReport)
    <div class="card">
        <div class="card-header">Latest Report: {{ $latestReport->report_name }}</div>
        <div class="card-body">
            <p><strong>Period:</strong> {{ $latestReport->date_from->format('M d, Y') }} - {{ $latestReport->date_to->format('M d, Y') }}</p>
            <p><strong>Total Payroll Cost:</strong> ₱{{ number_format($latestReport->total_payroll_cost, 2) }}</p>
            <p><strong>Total Overtime Cost:</strong> ₱{{ number_format($latestReport->total_overtime_cost, 2) }}</p>
        </div>
    </div>
    @endif
    
    <a href="{{ route('hr.hr4.analytics.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
