@extends('layouts.hr4.app')

@section('title', 'Compensation Planning - HR4')

@section('content')
<div class="container">
    <h2>Compensation Planning Module</h2>
    <p class="text-muted">Manage job grades, performance-based compensation, and salary adjustments</p>
    
    <div class="row">
        <!-- Job Grading -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-primary">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-layers"></i> Job Grading & Salary Structure
                </div>
                <div class="card-body">
                    <p>Define job levels and corresponding salary ranges</p>
                    <ul class="list-unstyled">
                        <li>• Entry Level</li>
                        <li>• Mid Level</li>
                        <li>• Senior Level</li>
                        <li>• Executive</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('hr.hr4.compensation.job-grading') }}" class="btn btn-primary w-100">Manage Job Grades</a>
                </div>
            </div>
        </div>

        <!-- Performance Based -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-success">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-star"></i> Performance Based Compensation
                </div>
                <div class="card-body">
                    <p>Calculate incentives based on performance metrics</p>
                    <ul class="list-unstyled">
                        <li>• Performance Rating</li>
                        <li>• KPI Achievement</li>
                        <li>• Attendance Score</li>
                        <li>• Patient Satisfaction</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('hr.hr4.compensation.performance') }}" class="btn btn-success w-100">Process Performance</a>
                </div>
            </div>
        </div>

        <!-- Review & Approval -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-warning">
                <div class="card-header bg-warning text-dark">
                    <i class="bi bi-check-circle"></i> Review & Approval Workflow
                </div>
                <div class="card-body">
                    <p>Review and approve compensation adjustments</p>
                    <ul class="list-unstyled">
                        <li>• Pending: 0</li>
                        <li>• Approved: 0</li>
                        <li>• Rejected: 0</li>
                        <li>• History</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('hr.hr4.compensation.review') }}" class="btn btn-warning w-100">Review Requests</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Action -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Quick Compensation Process</div>
                <div class="card-body text-center">
                    <p>Start the complete compensation planning workflow</p>
                    <a href="{{ route('hr.hr4.compensation.input') }}" class="btn btn-lg btn-primary">
                        <i class="bi bi-play-circle"></i> Start Compensation Process
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection