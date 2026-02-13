@extends('layouts.hr4.app')

@section('title', 'Manpower Reports - HR4')

@section('content')
<div class="container">
    <h2>Attrition & Manpower Planning Reports</h2>
    <p>Workforce planning and analysis</p>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Headcount Trends</div>
                <div class="card-body">
                    <p>Chart will appear here</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Attrition Analysis</div>
                <div class="card-body">
                    <p>Chart will appear here</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mt-3">
        <div class="card-header">Recommended HR Actions</div>
        <div class="card-body">
            <ul>
                <li>Monitor high-turnover departments</li>
                <li>Plan succession for key positions</li>
                <li>Adjust hiring forecasts</li>
            </ul>
        </div>
    </div>
    
    <a href="{{ route('hr.hr4.analytics.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection