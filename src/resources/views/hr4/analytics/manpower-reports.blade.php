@extends('layouts.hr4.app')

@section('title', 'Manpower Reports - HR4')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.index') }}">HR4</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.analytics.index') }}">Analytics</a></li>
            <li class="breadcrumb-item active">Manpower Reports</li>
        </ol>
    </nav>

    <h2>Attrition & Manpower Planning Reports</h2>
    <p class="text-muted">Workforce planning and analysis</p>
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">By Department</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead><tr><th>Department</th><th>Count</th><th>Avg Salary</th></tr></thead>
                        <tbody>
                            @forelse($departmentData as $d)
                            <tr>
                                <td>{{ $d->department }}</td>
                                <td>{{ $d->count }}</td>
                                <td>₱{{ number_format($d->avg_salary ?? 0, 0) }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center">No data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">By Job Grade</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead><tr><th>Grade</th><th>Count</th></tr></thead>
                        <tbody>
                            @forelse($gradeData as $g)
                            <tr>
                                <td>Grade {{ $g->job_grade }}</td>
                                <td>{{ $g->count }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="2" class="text-center">No data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">Recommended HR Actions</div>
        <div class="card-body">
            <ul class="mb-0">
                <li>Monitor high-turnover departments</li>
                <li>Plan succession for key positions</li>
                <li>Adjust hiring forecasts based on department needs</li>
            </ul>
        </div>
    </div>
    
    <a href="{{ route('hr.hr4.analytics.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
