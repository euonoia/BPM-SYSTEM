@extends('layouts.hr4.app')

@section('title', 'Human Capital Management - HR4')

@section('content')
<div class="container">
    <h2>Core Human Capital Management</h2>
    <p class="text-muted">Manage employee records, recruitment, and leave scheduling</p>
    
    <div class="row">
        <!-- Employee Records -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-primary">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-people"></i> Employee Records
                </div>
                <div class="card-body">
                    <p>Manage existing employee information</p>
                    <div class="row text-center">
                        <div class="col-6">
                            <h4>0</h4>
                            <small>Total</small>
                        </div>
                        <div class="col-6">
                            <h4>0</h4>
                            <small>Active</small>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('hr.hr4.human-capital.records') }}" class="btn btn-primary w-100">Manage</a>
                </div>
            </div>
        </div>

        <!-- Recruitment -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-success">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-person-plus"></i> Recruitment
                </div>
                <div class="card-body">
                    <p>Hire new employees</p>
                    <div class="row text-center">
                        <div class="col-6">
                            <h4>0</h4>
                            <small>Applicants</small>
                        </div>
                        <div class="col-6">
                            <h4>0</h4>
                            <small>New Hires</small>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('hr.hr4.human-capital.recruitment') }}" class="btn btn-success w-100">Recruit</a>
                </div>
            </div>
        </div>

        <!-- Leave & Scheduling -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-info">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-calendar-check"></i> Leave & Scheduling
                </div>
                <div class="card-body">
                    <p>Manage leaves and schedules</p>
                    <div class="row text-center">
                        <div class="col-6">
                            <h4>0</h4>
                            <small>On Leave</small>
                        </div>
                        <div class="col-6">
                            <h4>0</h4>
                            <small>Pending</small>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('hr.hr4.human-capital.leave-scheduling') }}" class="btn btn-info w-100">Schedule</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Action -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Employee Workflow</div>
                <div class="card-body text-center">
                    <p>Process new or existing employee</p>
                    <a href="{{ route('hr.hr4.human-capital.process') }}" class="btn btn-lg btn-primary">
                        <i class="bi bi-play-circle"></i> Process Employee
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection