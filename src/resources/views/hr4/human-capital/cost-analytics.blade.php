@extends('layouts.hr4.app')

@section('title', 'Cost Analytics - HR4')

@section('content')
<div class="container">
    <h2>Payroll & Labor Cost Analytics</h2>
    <p>Financial analysis of HR costs</p>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Total Payroll</div>
                <div class="card-body text-center">
                    <h3>₱0.00</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Overtime Costs</div>
                <div class="card-body text-center">
                    <h3>₱0.00</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Cost Per Employee</div>
                <div class="card-body text-center">
                    <h3>₱0.00</h3>
                </div>
            </div>
        </div>
    </div>
    
    <a href="{{ route('hr.hr4.analytics.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection