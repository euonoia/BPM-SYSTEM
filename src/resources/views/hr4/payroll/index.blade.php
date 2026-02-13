@extends('layouts.hr4.app')

@section('title', 'Payroll - HR4')

@section('content')
<div class="container">
    <h2>Payroll Module</h2>
    <p class="text-muted">Process employee payroll with validation</p>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    Step 1: Data Input
                </div>
                <div class="card-body">
                    <p>Input timekeeping and employee data</p>
                    <a href="{{ route('hr.hr4.payroll.input') }}" class="btn btn-primary">Start Payroll Process</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-header bg-warning text-dark">
                    Pending Corrections
                </div>
                <div class="card-body">
                    <h3>0</h3>
                    <p>Records needing correction</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    Completed
                </div>
                <div class="card-body">
                    <h3>0</h3>
                    <p>Successfully processed</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection