@extends('layouts.hr4.app')

@section('title', 'HR4 Dashboard')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2>HR4 Dashboard</h2>
            <p class="text-muted">Hospital Management System - Human Resources Module</p>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h3>{{ $stats['total_employees'] ?? 0 }}</h3>
                    <p class="mb-0">Total Employees</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h3>{{ $stats['active_employees'] ?? 0 }}</h3>
                    <p class="mb-0">Active Employees</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body text-center">
                    <h3>{{ $stats['pending_compensations'] ?? 0 }}</h3>
                    <p class="mb-0">Pending Compensations</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h3>{{ $stats['total_payrolls_this_month'] ?? 0 }}</h3>
                    <p class="mb-0">Payrolls This Month</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 4 Main Modules -->
    <div class="row">
        <!-- PAYROLL -->
        <div class="col-md-3 mb-4">
            <div class="card h-100 border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">1. PAYROLL</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('hr.hr4.payroll.time-keeping') }}" class="text-decoration-none">⏱ Time Keeping & Shift</a></li>
                        <li><a href="{{ route('hr.hr4.payroll.computation') }}" class="text-decoration-none">🧮 Automated Computation</a></li>
                        <li><a href="{{ route('hr.hr4.payroll.payslip') }}" class="text-decoration-none">📄 Payslip & Government</a></li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('hr.hr4.payroll.index') }}" class="btn btn-primary btn-sm w-100">Go to Payroll</a>
                </div>
            </div>
        </div>

        <!-- COMPENSATION -->
        <div class="col-md-3 mb-4">
            <div class="card h-100 border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">2. COMPENSATION</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('hr.hr4.compensation.job-grading') }}" class="text-decoration-none">📊 Job Grading</a></li>
                        <li><a href="{{ route('hr.hr4.compensation.performance') }}" class="text-decoration-none">⭐ Performance Based</a></li>
                        <li><a href="{{ route('hr.hr4.compensation.review') }}" class="text-decoration-none">✅ Review & Approval</a></li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('hr.hr4.compensation.index') }}" class="btn btn-success btn-sm w-100">Go to Compensation</a>
                </div>
            </div>
        </div>

        <!-- HUMAN CAPITAL -->
        <div class="col-md-3 mb-4">
            <div class="card h-100 border-info">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">3. HUMAN CAPITAL</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('hr.hr4.human-capital.records') }}" class="text-decoration-none">👥 Employee Records</a></li>
                        <li><a href="{{ route('hr.hr4.human-capital.recruitment') }}" class="text-decoration-none">🎯 Recruitment</a></li>
                        <li><a href="{{ route('hr.hr4.human-capital.leave-scheduling') }}" class="text-decoration-none">📅 Leave & Scheduling</a></li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('hr.hr4.human-capital.index') }}" class="btn btn-info btn-sm w-100">Go to Human Capital</a>
                </div>
            </div>
        </div>

        <!-- ANALYTICS -->
        <div class="col-md-3 mb-4">
            <div class="card h-100 border-warning">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">4. HR ANALYTICS</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('hr.hr4.analytics.kpi-dashboard') }}" class="text-decoration-none">📈 KPI Dashboard</a></li>
                        <li><a href="{{ route('hr.hr4.analytics.cost-analytics') }}" class="text-decoration-none">💰 Cost Analytics</a></li>
                        <li><a href="{{ route('hr.hr4.analytics.manpower-reports') }}" class="text-decoration-none">📉 Manpower Reports</a></li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('hr.hr4.analytics.index') }}" class="btn btn-warning btn-sm w-100">Go to Analytics</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection