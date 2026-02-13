@extends('layouts.hr4.app')

@section('title', 'Time Keeping - HR4')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.index') }}">HR4</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.payroll.index') }}">Payroll</a></li>
            <li class="breadcrumb-item active">Time Keeping</li>
        </ol>
    </nav>

    <h2>Time Keeping & Shift Management</h2>
    <p class="text-muted">Track attendance, overtime, and shifts</p>
    
    <div class="card">
        <div class="card-body">
            <p>Time keeping data is entered through the <a href="{{ route('hr.hr4.payroll.input') }}">Payroll Input</a> form.</p>
            <p>For each payroll run, enter:</p>
            <ul>
                <li>Days worked</li>
                <li>Overtime hours</li>
                <li>Night differential hours</li>
                <li>Late minutes</li>
                <li>Absent days</li>
            </ul>
            <a href="{{ route('hr.hr4.payroll.input') }}" class="btn btn-primary">Go to Payroll Input</a>
            <a href="{{ route('hr.hr4.payroll.index') }}" class="btn btn-secondary">Back to Payroll</a>
        </div>
    </div>
</div>
@endsection
