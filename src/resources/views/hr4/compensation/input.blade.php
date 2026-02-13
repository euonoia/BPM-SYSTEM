@extends('layouts.hr4.app')

@section('title', 'Compensation Input - HR4')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.index') }}">HR4</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.compensation.index') }}">Compensation</a></li>
            <li class="breadcrumb-item active">Data Input</li>
        </ol>
    </nav>

    <h2>Step 1: Receive Job Grades & Performance Data</h2>
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('hr.hr4.compensation.validate') }}" method="POST">
        @csrf
        
        <!-- Employee Selection -->
        <div class="card mb-3">
            <div class="card-header">Employee Information</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Employee ID</label>
                        <input type="text" name="employee_id" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Employee Name</label>
                        <input type="text" name="employee_name" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Job Grade Information -->
        <div class="card mb-3">
            <div class="card-header">Job Grade & Salary Structure</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Current Job Grade</label>
                        <select name="current_grade" class="form-control" required>
                            <option value="">Select Grade</option>
                            <option value="1">Grade 1 - Entry Level</option>
                            <option value="2">Grade 2 - Junior</option>
                            <option value="3">Grade 3 - Mid Level</option>
                            <option value="4">Grade 4 - Senior</option>
                            <option value="5">Grade 5 - Executive</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Current Basic Salary</label>
                        <input type="number" name="current_salary" class="form-control" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Proposed Job Grade (if promotion)</label>
                        <select name="proposed_grade" class="form-control">
                            <option value="">No Change</option>
                            <option value="1">Grade 1 - Entry Level</option>
                            <option value="2">Grade 2 - Junior</option>
                            <option value="3">Grade 3 - Mid Level</option>
                            <option value="4">Grade 4 - Senior</option>
                            <option value="5">Grade 5 - Executive</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Years in Current Position</label>
                        <input type="number" name="years_in_position" class="form-control" min="0" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Data -->
        <div class="card mb-3">
            <div class="card-header">Performance Data</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Performance Rating (1-5)</label>
                        <select name="performance_rating" class="form-control" required>
                            <option value="">Select Rating</option>
                            <option value="5">5 - Outstanding</option>
                            <option value="4">4 - Exceeds Expectations</option>
                            <option value="3">3 - Meets Expectations</option>
                            <option value="2">2 - Needs Improvement</option>
                            <option value="1">1 - Unsatisfactory</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>KPI Achievement %</label>
                        <input type="number" name="kpi_achievement" class="form-control" min="0" max="200" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Attendance Score %</label>
                        <input type="number" name="attendance_score" class="form-control" min="0" max="100" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label>Special Achievements / Awards</label>
                    <textarea name="special_achievements" class="form-control" rows="2"></textarea>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Validate Data</button>
            <a href="{{ route('hr.hr4.compensation.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection