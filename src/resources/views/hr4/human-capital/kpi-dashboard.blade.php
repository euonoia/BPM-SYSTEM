@extends('layouts.hr4.app')

@section('title', 'KPI Dashboard - HR4')

@section('content')
<div class="container">
    <h2>HR KPI Dashboard</h2>
    <p>Key Performance Indicators</p>
    
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-primary text-white text-center">
                <div class="card-body">
                    <h3>0%</h3>
                    <p>Turnover Rate</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white text-center">
                <div class="card-body">
                    <h3>0 days</h3>
                    <p>Time to Hire</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white text-center">
                <div class="card-body">
                    <h3>0%</h3>
                    <p>Training Effectiveness</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark text-center">
                <div class="card-body">
                    <h3>0/5</h3>
                    <p>Satisfaction Score</p>
                </div>
            </div>
        </div>
    </div>
    
    <a href="{{ route('hr.hr4.analytics.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection