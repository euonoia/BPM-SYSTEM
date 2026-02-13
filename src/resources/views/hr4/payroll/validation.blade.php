@extends('layouts.hr4.app')

@section('title', 'Payroll Validation - HR4')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.index') }}">HR4</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.payroll.index') }}">Payroll</a></li>
            <li class="breadcrumb-item active">Data Validation</li>
        </ol>
    </nav>

    <h2>Step 2: Data Validation</h2>
    
    <div class="card {{ $is_complete ? 'border-success' : 'border-danger' }}">
        <div class="card-header {{ $is_complete ? 'bg-success' : 'bg-danger' }} text-white">
            Validation Result: {{ $is_complete ? 'COMPLETE' : 'INCOMPLETE' }}
        </div>
        <div class="card-body">
            <h5>Data Completeness Check</h5>
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between">
                    Employee ID
                    <span class="badge {{ $data['employee_id'] ? 'bg-success' : 'bg-danger' }}">
                        {{ $data['employee_id'] ? '✓' : '✗' }}
                    </span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    Employee Name
                    <span class="badge {{ $data['employee_name'] ? 'bg-success' : 'bg-danger' }}">
                        {{ $data['employee_name'] ? '✓' : '✗' }}
                    </span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    Department
                    <span class="badge {{ $data['department'] ? 'bg-success' : 'bg-danger' }}">
                        {{ $data['department'] ? '✓' : '✗' }}
                    </span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    Days Worked
                    <span class="badge {{ $data['days_worked'] > 0 ? 'bg-success' : 'bg-danger' }}">
                        {{ $data['days_worked'] > 0 ? '✓' : '✗' }}
                    </span>
                </li>
            </ul>

            @if($is_complete)
                <div class="alert alert-success">
                    <strong>✓ Data Complete!</strong> Proceed to payroll computation.
                </div>
                <a href="{{ route('hr.hr4.payroll.compute') }}" class="btn btn-success">Compute Payroll</a>
            @else
                <div class="alert alert-danger">
                    <strong>✗ Data Incomplete!</strong> Please provide missing information.
                </div>
                <a href="{{ route('hr.hr4.payroll.input') }}" class="btn btn-warning">Request Correction</a>
            @endif
        </div>
    </div>
</div>
@endsection