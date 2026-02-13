@extends('layouts.hr4.app')

@section('title', 'Payroll Input - HR4')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.index') }}">HR4</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.payroll.index') }}">Payroll</a></li>
            <li class="breadcrumb-item active">Data Input</li>
        </ol>
    </nav>

    <h2>Step 1: Receive Timekeeping & Employee Data</h2>
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('hr.hr4.payroll.validate') }}" method="POST">
        @csrf
        
        <div class="card">
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
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Department</label>
                        <select name="department" class="form-control" required>
                            <option value="">Select Department</option>
                            <option value="nursing">Nursing</option>
                            <option value="medical">Medical</option>
                            <option value="admin">Administration</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Position</label>
                        <input type="text" name="position" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">Timekeeping Data</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Days Worked</label>
                        <input type="number" name="days_worked" class="form-control" min="0" max="31" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Overtime Hours</label>
                        <input type="number" name="overtime_hours" class="form-control" min="0" value="0">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Night Differential Hours</label>
                        <input type="number" name="night_diff_hours" class="form-control" min="0" value="0">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Leaves Taken</label>
                        <input type="number" name="leaves_taken" class="form-control" min="0" value="0">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Late Minutes</label>
                        <input type="number" name="late_minutes" class="form-control" min="0" value="0">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Absent Days</label>
                        <input type="number" name="absent_days" class="form-control" min="0" value="0">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Validate Data</button>
            <a href="{{ route('hr.hr4.payroll.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection