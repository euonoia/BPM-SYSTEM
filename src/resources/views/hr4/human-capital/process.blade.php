@extends('layouts.hr4.app')

@section('title', 'Process Employee - HR4')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.index') }}">HR4</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.human-capital.index') }}">Human Capital</a></li>
            <li class="breadcrumb-item active">Process</li>
        </ol>
    </nav>

    <h2>Step 1: Receive Employee Information</h2>

    <form action="{{ route('hr.hr4.human-capital.check-employee') }}" method="POST">
        @csrf
        
        <div class="card mb-3">
            <div class="card-header">Employee Identification</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Employee ID</label>
                        <input type="text" name="employee_id" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Employee Name</label>
                        <input type="text" name="employee_name" class="form-control">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label>Employee Type</label>
                    <select name="employee_type" class="form-control" required>
                        <option value="">Select</option>
                        <option value="new">New Employee</option>
                        <option value="existing">Existing Employee</option>
                    </select>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Check Employee</button>
        <a href="{{ route('hr.hr4.human-capital.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection