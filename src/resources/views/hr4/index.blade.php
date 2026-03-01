@extends('layouts.hr4.app')

@section('title', 'HR4 Dashboard')

@section('content')
<div class="container">
    <!-- Header -->
    <div style="margin-bottom: 40px;">
        <h2>HR4 Dashboard</h2>
        <p class="text-muted">Hospital Management System - Human Resources Module</p>
    </div>

    <!-- Stats Overview -->
    <div class="row" style="margin-bottom: 40px;">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #0F4C75 0%, #1B6BA8 100%);">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['total_employees'] ?? 0 }}</h3>
                    <p>Total Employees</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #27AE60 0%, #2ECC71 100%);">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['active_employees'] ?? 0 }}</h3>
                    <p>Active Employees</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #F39C12 0%, #F1C40F 100%);">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['pending_compensations'] ?? 0 }}</h3>
                    <p>Pending Compensations</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #3498DB 0%, #5BA3D0 100%);">
                    <i class="bi bi-receipt"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['total_payrolls_this_month'] ?? 0 }}</h3>
                    <p>Payrolls This Month</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 4 Main Modules -->
    <div>
        <h3 style="margin-bottom: 25px; color: #0F4C75;">Quick Access Modules</h3>
        <div class="row">
            <!-- PAYROLL -->
            <div class="col-md-3 mb-4">
                <div class="module-card">
                    <div class="module-header" style="background: linear-gradient(135deg, #0F4C75 0%, #1B6BA8 100%);">
                        <i class="bi bi-cash-coin"></i>
                        <h5>PAYROLL</h5>
                    </div>
                    <div class="module-body">
                        <ul class="module-list">
                            <li><a href="{{ route('hr.hr4.payroll.time-keeping') }}"><i class="bi bi-clock"></i> Time Keeping & Shift</a></li>
                            <li><a href="{{ route('hr.hr4.payroll.computation') }}"><i class="bi bi-calculator"></i> Automated Computation</a></li>
                            <li><a href="{{ route('hr.hr4.payroll.payslip') }}"><i class="bi bi-file-earmark"></i> Payslip & Government</a></li>
                        </ul>
                    </div>
                    <div class="module-footer">
                        <a href="{{ route('hr.hr4.payroll.index') }}" class="btn btn-primary">View Payroll</a>
                    </div>
                </div>
            </div>

            <!-- COMPENSATION -->
            <div class="col-md-3 mb-4">
                <div class="module-card">
                    <div class="module-header" style="background: linear-gradient(135deg, #27AE60 0%, #2ECC71 100%);">
                        <i class="bi bi-graph-up"></i>
                        <h5>COMPENSATION</h5>
                    </div>
                    <div class="module-body">
                        <ul class="module-list">
                            <li><a href="{{ route('hr.hr4.compensation.job-grading') }}"><i class="bi bi-building"></i> Job Grading</a></li>
                            <li><a href="{{ route('hr.hr4.compensation.performance') }}"><i class="bi bi-star"></i> Performance Based</a></li>
                            <li><a href="{{ route('hr.hr4.compensation.review') }}"><i class="bi bi-check-circle"></i> Review & Approval</a></li>
                        </ul>
                    </div>
                    <div class="module-footer">
                        <a href="{{ route('hr.hr4.compensation.index') }}" class="btn btn-primary">View Compensation</a>
                    </div>
                </div>
            </div>

            <!-- HUMAN CAPITAL -->
            <div class="col-md-3 mb-4">
                <div class="module-card">
                    <div class="module-header" style="background: linear-gradient(135deg, #3498DB 0%, #5BA3D0 100%);">
                        <i class="bi bi-people"></i>
                        <h5>HUMAN CAPITAL</h5>
                    </div>
                    <div class="module-body">
                        <ul class="module-list">
                            <li><a href="{{ route('hr.hr4.human-capital.records') }}"><i class="bi bi-person-vcard"></i> Employee Records</a></li>
                            <li><a href="{{ route('hr.hr4.human-capital.recruitment') }}"><i class="bi bi-target"></i> Recruitment</a></li>
                            <li><a href="{{ route('hr.hr4.human-capital.leave-scheduling') }}"><i class="bi bi-calendar-event"></i> Leave & Scheduling</a></li>
                        </ul>
                    </div>
                    <div class="module-footer">
                        <a href="{{ route('hr.hr4.human-capital.index') }}" class="btn btn-primary">View Human Capital</a>
                    </div>
                </div>
            </div>

            <!-- ANALYTICS -->
            <div class="col-md-3 mb-4">
                <div class="module-card">
                    <div class="module-header" style="background: linear-gradient(135deg, #F39C12 0%, #F1C40F 100%);">
                        <i class="bi bi-bar-chart"></i>
                        <h5>HR ANALYTICS</h5>
                    </div>
                    <div class="module-body">
                        <ul class="module-list">
                            <li><a href="{{ route('hr.hr4.analytics.kpi-dashboard') }}"><i class="bi bi-graph-up-arrow"></i> KPI Dashboard</a></li>
                            <li><a href="{{ route('hr.hr4.analytics.cost-analytics') }}"><i class="bi bi-cash-flow"></i> Cost Analytics</a></li>
                            <li><a href="{{ route('hr.hr4.analytics.manpower-reports') }}"><i class="bi bi-file-bar-graph"></i> Manpower Reports</a></li>
                        </ul>
                    </div>
                    <div class="module-footer">
                        <a href="{{ route('hr.hr4.analytics.index') }}" class="btn btn-primary">View Analytics</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.stat-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 20px;
    transition: all 0.3s ease;
}

.stat-card:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
    transform: translateY(-2px);
}

.stat-icon {
    width: 70px;
    height: 70px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 32px;
    flex-shrink: 0;
}

.stat-content h3 {
    margin: 0;
    font-size: 24px;
    color: #0F4C75;
    font-weight: 700;
}

.stat-content p {
    margin: 5px 0 0 0;
    color: #7F8C8D;
    font-size: 13px;
}

.module-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.module-card:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
    transform: translateY(-5px);
}

.module-header {
    padding: 20px;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 600;
}

.module-header i {
    font-size: 24px;
}

.module-header h5 {
    margin: 0;
    font-size: 14px;
    letter-spacing: 1px;
}

.module-body {
    padding: 15px;
    flex: 1;
}

.module-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.module-list li {
    margin-bottom: 12px;
}

.module-list li:last-child {
    margin-bottom: 0;
}

.module-list li a {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #0F4C75;
    text-decoration: none;
    font-size: 13px;
    transition: all 0.3s ease;
    padding: 5px 0;
}

.module-list li a:hover {
    color: #1B6BA8;
    padding-left: 5px;
}

.module-list li a i {
    font-size: 16px;
}

.module-footer {
    padding: 15px;
    border-top: 1px solid #E1E8ED;
}

.module-footer .btn {
    width: 100%;
}
</style>
@endsection