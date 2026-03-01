@extends('layouts.hr4.app')

@section('title', 'Human Capital Management - HR4')

@section('content')
<div class="container">
    <div style="margin-bottom: 40px;">
        <h2>Core Human Capital Management</h2>
        <p class="text-muted">Manage employee records, recruitment, and leave scheduling</p>
    </div>
    
    <div class="row" style="margin-bottom: 30px;">
        <!-- Employee Records -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header" style="background: linear-gradient(135deg, #0F4C75 0%, #1B6BA8 100%);">
                    <i class="bi bi-people"></i> Employee Records
                </div>
                <div class="card-body">
                    <p class="text-muted">Manage existing employee information and profiles</p>
                    <div class="row text-center" style="margin: 20px 0;">
                        <div class="col-6">
                            <div style="padding: 15px; background: var(--bg); border-radius: 8px;">
                                <h4 style="color: #0F4C75; margin: 0;">0</h4>
                                <small style="color: var(--text-light);">Total</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="padding: 15px; background: var(--bg); border-radius: 8px;">
                                <h4 style="color: #27AE60; margin: 0;">0</h4>
                                <small style="color: var(--text-light);">Active</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('hr.hr4.human-capital.records') }}" class="btn btn-primary" style="width: 100%;">View Records</a>
                </div>
            </div>
        </div>

        <!-- Recruitment -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header" style="background: linear-gradient(135deg, #27AE60 0%, #2ECC71 100%);">
                    <i class="bi bi-person-plus"></i> Recruitment
                </div>
                <div class="card-body">
                    <p class="text-muted">Hire and onboard new employees</p>
                    <div class="row text-center" style="margin: 20px 0;">
                        <div class="col-6">
                            <div style="padding: 15px; background: var(--bg); border-radius: 8px;">
                                <h4 style="color: #0F4C75; margin: 0;">0</h4>
                                <small style="color: var(--text-light);">Applicants</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="padding: 15px; background: var(--bg); border-radius: 8px;">
                                <h4 style="color: #27AE60; margin: 0;">0</h4>
                                <small style="color: var(--text-light);">New Hires</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('hr.hr4.human-capital.recruitment') }}" class="btn btn-primary" style="width: 100%;">Manage Recruitment</a>
                </div>
            </div>
        </div>

        <!-- Leave & Scheduling -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header" style="background: linear-gradient(135deg, #3498DB 0%, #5BA3D0 100%);">
                    <i class="bi bi-calendar-check"></i> Leave & Scheduling
                </div>
                <div class="card-body">
                    <p class="text-muted">Manage leaves and work schedules</p>
                    <div class="row text-center" style="margin: 20px 0;">
                        <div class="col-6">
                            <div style="padding: 15px; background: var(--bg); border-radius: 8px;">
                                <h4 style="color: #0F4C75; margin: 0;">0</h4>
                                <small style="color: var(--text-light);">On Leave</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="padding: 15px; background: var(--bg); border-radius: 8px;">
                                <h4 style="color: #F39C12; margin: 0;">0</h4>
                                <small style="color: var(--text-light);">Pending</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('hr.hr4.human-capital.leave-scheduling') }}" class="btn btn-primary" style="width: 100%;">Manage Schedule</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Action -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-lightning"></i> Quick Actions
                </div>
                <div class="card-body">
                    <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                        <a href="{{ route('hr.hr4.human-capital.process') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-play-circle"></i> Process Employee
                        </a>
                        <a href="{{ route('hr.hr4.human-capital.records') }}" class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-file-earmark"></i> View All Records
                        </a>
                        <a href="{{ route('hr.hr4.human-capital.recruitment') }}" class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-person-fill-add"></i> New Recruitment
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection