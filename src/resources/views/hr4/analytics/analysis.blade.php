@extends('layouts.hr4.app')

@section('title', 'Analysis - HR4')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.index') }}">HR4</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.analytics.index') }}">Analytics</a></li>
            <li class="breadcrumb-item active">Analysis</li>
        </ol>
    </nav>

    <h2>Step 2-3: Analyze Payroll & Labor Costs / Check Data Accuracy</h2>

    <div class="card {{ $is_accurate ? 'border-success' : 'border-warning' }}">
        <div class="card-header {{ $is_accurate ? 'bg-success' : 'bg-warning' }} text-white">
            Data Accuracy Check: {{ $is_accurate ? 'ACCURATE' : 'NEEDS VALIDATION' }}
        </div>
        <div class="card-body">
            <h5>Analysis Period: {{ $date_from }} to {{ $date_to }}</h5>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <h6>Payroll Summary</h6>
                    <table class="table table-sm">
                        <tr>
                            <td>Total Payroll</td>
                            <td class="text-end">₱{{ number_format($analysis['total_payroll'], 2) }}</td>
                        </tr>
                        <tr>
                            <td>Overtime Costs</td>
                            <td class="text-end">₱{{ number_format($analysis['overtime_costs'], 2) }}</td>
                        </tr>
                        <tr>
                            <td>Benefits</td>
                            <td class="text-end">₱{{ number_format($analysis['benefits_costs'], 2) }}</td>
                        </tr>
                        <tr class="table-primary">
                            <th>Total Labor Cost</th>
                            <th class="text-end">₱{{ number_format($analysis['total_labor_cost'], 2) }}</th>
                        </tr>
                    </table>
                </div>
                
                <div class="col-md-6">
                    <h6>HR Metrics</h6>
                    <table class="table table-sm">
                        <tr>
                            <td>Active Employees</td>
                            <td class="text-end">{{ $analysis['headcount'] }}</td>
                        </tr>
                        <tr>
                            <td>Cost Per Employee</td>
                            <td class="text-end">₱{{ number_format($analysis['cost_per_employee'], 2) }}</td>
                        </tr>
                        <tr>
                            <td>Turnover Rate</td>
                            <td class="text-end">{{ number_format($analysis['turnover_rate'], 2) }}%</td>
                        </tr>
                        <tr>
                            <td>Avg Attendance</td>
                            <td class="text-end">{{ number_format($analysis['avg_attendance'], 2) }}%</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($is_accurate)
                <div class="alert alert-success mt-3">
                    <strong>✓ Data Accurate!</strong> Ready to generate reports.
                </div>
                <a href="{{ route('hr.hr4.analytics.generate') }}" class="btn btn-success btn-lg">
                    <i class="bi bi-file-earmark-bar-graph"></i> Generate KPI Reports
                </a>
            @else
                <div class="alert alert-warning mt-3">
                    <strong>⚠ Data Issues Detected!</strong> Some data needs validation.
                </div>
                <a href="{{ route('hr.hr4.analytics.clean') }}" class="btn btn-warning btn-lg">
                    <i class="bi bi-tools"></i> Clean/Validate Data
                </a>
            @endif
        </div>
    </div>
</div>
@endsection