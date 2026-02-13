@extends('layouts.hr4.app')

@section('title', 'HR Analytics - HR4')

@section('content')
<div class="container">
    <h2>HR Analytics</h2>
    <p class="text-muted">Data-driven insights for HR decision making</p>
    
    <div class="row">
        <!-- KPI Dashboard -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-primary">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-speedometer2"></i> HR KPI Dashboard
                </div>
                <div class="card-body">
                    <p>Key Performance Indicators</p>
                    <ul class="list-unstyled">
                        <li>• Employee Turnover Rate</li>
                        <li>• Time to Hire</li>
                        <li>• Training Effectiveness</li>
                        <li>• Employee Satisfaction</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('hr.hr4.analytics.kpi-dashboard') }}" class="btn btn-primary w-100">View KPIs</a>
                </div>
            </div>
        </div>

        <!-- Cost Analytics -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-success">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-cash-stack"></i> Payroll & Labor Cost
                </div>
                <div class="card-body">
                    <p>Financial analytics</p>
                    <ul class="list-unstyled">
                        <li>• Total Payroll Costs</li>
                        <li>• Cost Per Employee</li>
                        <li>• Overtime Analysis</li>
                        <li>• Budget vs Actual</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('hr.hr4.analytics.cost-analytics') }}" class="btn btn-success w-100">View Costs</a>
                </div>
            </div>
        </div>

        <!-- Manpower Reports -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-warning">
                <div class="card-header bg-warning text-dark">
                    <i class="bi bi-people-fill"></i> Attrition & Manpower
                </div>
                <div class="card-body">
                    <p>Workforce planning</p>
                    <ul class="list-unstyled">
                        <li>• Headcount Trends</li>
                        <li>• Attrition Analysis</li>
                        <li>• Succession Planning</li>
                        <li>• Hiring Forecasts</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('hr.hr4.analytics.manpower-reports') }}" class="btn btn-warning w-100">View Reports</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Collection -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Data Collection & Analysis</div>
                <div class="card-body text-center">
                    <p>Collect and analyze data from all HR modules</p>
                    <a href="{{ route('hr.hr4.analytics.collect') }}" class="btn btn-lg btn-primary">
                        <i class="bi bi-cloud-download"></i> Collect Data
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection