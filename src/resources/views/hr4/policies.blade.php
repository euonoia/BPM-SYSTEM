@extends('layouts.hr4.app')

@section('title', 'Policies - HR4')

@section('content')
<div class="container">
    <h2>HR Policies</h2>
    <p class="text-muted">Hospital HR policies and guidelines</p>
    
    <div class="card">
        <div class="card-body">
            <h5>Payroll Policy</h5>
            <p>Payroll is processed monthly. Employees must submit timekeeping data by the 25th of each month.</p>
            
            <h5>Compensation Policy</h5>
            <p>Compensation adjustments are reviewed quarterly. Performance-based increases require approval from HR Admin.</p>
            
            <h5>Leave Policy</h5>
            <p>Annual leave is accrued based on years of service. Sick leave and emergency leave are available per company policy.</p>
        </div>
    </div>
</div>
@endsection
