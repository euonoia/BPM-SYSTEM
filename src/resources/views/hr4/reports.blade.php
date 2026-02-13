@extends('layouts.hr4.app')

@section('title', 'Reports - HR4')

@section('content')
<div class="container">
    <h2>HR Reports</h2>
    <p class="text-muted">Generate and view HR reports</p>
    
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5>Analytics Reports</h5>
                    <p>KPI, cost, and manpower reports</p>
                    <a href="{{ route('hr.hr4.analytics.index') }}" class="btn btn-primary">View Analytics</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5>Payroll Reports</h5>
                    <p>Payroll history and summaries</p>
                    <a href="{{ route('hr.hr4.payroll.index') }}" class="btn btn-success">View Payroll</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5>Compensation Reports</h5>
                    <p>Adjustment and review reports</p>
                    <a href="{{ route('hr.hr4.compensation.index') }}" class="btn btn-info">View Compensation</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
