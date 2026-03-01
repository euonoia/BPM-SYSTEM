@extends('layouts.hr4.app')

@section('title', 'Compensation Planning - HR4')

@section('content')
<div class="container">
    <div style="margin-bottom: 40px;">
        <h2>Compensation Planning Module</h2>
        <p class="text-muted">Manage job grades, performance-based compensation, and salary adjustments</p>
    </div>
    
    <div class="row" style="margin-bottom: 30px;">
        <!-- Job Grading -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header" style="background: linear-gradient(135deg, #0F4C75 0%, #1B6BA8 100%);">
                    <i class="bi bi-layers"></i> Job Grading & Salary Structure
                </div>
                <div class="card-body">
                    <p class="text-muted">Define job levels and corresponding salary ranges</p>
                    <ul style="list-style: none; padding: 0; margin: 15px 0;">
                        <li style="padding: 8px 0;"><i class="bi bi-check-circle" style="color: #27AE60;"></i> Entry Level</li>
                        <li style="padding: 8px 0;"><i class="bi bi-check-circle" style="color: #27AE60;"></i> Mid Level</li>
                        <li style="padding: 8px 0;"><i class="bi bi-check-circle" style="color: #27AE60;"></i> Senior Level</li>
                        <li style="padding: 8px 0;"><i class="bi bi-check-circle" style="color: #27AE60;"></i> Executive</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('hr.hr4.compensation.job-grading') }}" class="btn btn-primary" style="width: 100%;">Manage Job Grades</a>
                </div>
            </div>
        </div>

        <!-- Performance Based -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header" style="background: linear-gradient(135deg, #27AE60 0%, #2ECC71 100%);">
                    <i class="bi bi-star"></i> Performance Based Compensation
                </div>
                <div class="card-body">
                    <p class="text-muted">Calculate incentives based on performance metrics</p>
                    <ul style="list-style: none; padding: 0; margin: 15px 0;">
                        <li style="padding: 8px 0;"><i class="bi bi-check-circle" style="color: #0F4C75;"></i> Performance Rating</li>
                        <li style="padding: 8px 0;"><i class="bi bi-check-circle" style="color: #0F4C75;"></i> KPI Achievement</li>
                        <li style="padding: 8px 0;"><i class="bi bi-check-circle" style="color: #0F4C75;"></i> Attendance Score</li>
                        <li style="padding: 8px 0;"><i class="bi bi-check-circle" style="color: #0F4C75;"></i> Patient Satisfaction</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('hr.hr4.compensation.performance') }}" class="btn btn-primary" style="width: 100%;">Process Performance</a>
                </div>
            </div>
        </div>

        <!-- Review & Approval -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header" style="background: linear-gradient(135deg, #F39C12 0%, #F1C40F 100%);">
                    <i class="bi bi-check-circle"></i> Review & Approval Workflow
                </div>
                <div class="card-body">
                    <p class="text-muted">Review and approve compensation adjustments</p>
                    <div style="margin: 15px 0; display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div style="padding: 12px; background: var(--bg); border-radius: 6px; text-align: center;">
                            <h5 style="color: #F39C12; margin: 0;">0</h5>
                            <small style="color: var(--text-light);">Pending</small>
                        </div>
                        <div style="padding: 12px; background: var(--bg); border-radius: 6px; text-align: center;">
                            <h5 style="color: #27AE60; margin: 0;">0</h5>
                            <small style="color: var(--text-light);">Approved</small>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('hr.hr4.compensation.review') }}" class="btn btn-primary" style="width: 100%;">Review Requests</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Action -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-lightning"></i> Quick Compensation Process
                </div>
                <div class="card-body text-center" style="padding: 40px 20px;">
                    <p class="text-muted" style="margin-bottom: 20px;">Start the complete compensation planning workflow</p>
                    <a href="{{ route('hr.hr4.compensation.input') }}" class="btn btn-lg btn-primary">
                        <i class="bi bi-play-circle"></i> Start Compensation Process
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection