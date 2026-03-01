@extends('layouts.hr4.app')

@section('title', 'Payroll - HR4')

@section('content')
<div class="container">
    <div style="margin-bottom: 40px;">
        <h2>Payroll Module</h2>
        <p class="text-muted">Process employee payroll with validation</p>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-pencil"></i> Step 1: Data Input
                </div>
                <div class="card-body">
                    <p class="text-muted">Input timekeeping and employee data for payroll processing</p>
                    <a href="{{ route('hr.hr4.payroll.input') }}" class="btn btn-primary" style="width: 100%; margin-top: 10px;">
                        <i class="bi bi-arrow-right"></i> Start Payroll Process
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #F39C12 0%, #F1C40F 100%); color: #fff;">
                    <i class="bi bi-exclamation-circle"></i> Pending Corrections
                </div>
                <div class="card-body text-center">
                    <h3 style="color: #F39C12; font-size: 32px; margin: 0;">0</h3>
                    <p class="text-muted" style="margin-top: 10px;">Records needing correction</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #27AE60 0%, #2ECC71 100%); color: #fff;">
                    <i class="bi bi-check-circle"></i> Completed
                </div>
                <div class="card-body text-center">
                    <h3 style="color: #27AE60; font-size: 32px; margin: 0;">0</h3>
                    <p class="text-muted" style="margin-top: 10px;">Successfully processed</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection