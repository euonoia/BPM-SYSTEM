@extends('layouts.hr4.app')

@section('title', 'Cost Analytics - HR4')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.index') }}">HR4</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.analytics.index') }}">Analytics</a></li>
            <li class="breadcrumb-item active">Cost Analytics</li>
        </ol>
    </nav>

    <h2>Payroll & Labor Cost Analytics</h2>
    <p class="text-muted">Financial analysis of HR costs</p>
    
    @php
        $totalPayroll = $costData->sum('total_payroll');
        $totalOvertime = $costData->sum('total_overtime');
        $empCount = \App\Models\Employee::active()->count();
        $costPerEmp = $empCount > 0 ? $totalPayroll / $empCount : 0;
    @endphp

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-header">Total Payroll</div>
                <div class="card-body text-center">
                    <h3>₱{{ number_format($totalPayroll, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-header">Overtime Costs</div>
                <div class="card-body text-center">
                    <h3>₱{{ number_format($totalOvertime, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-header">Cost Per Employee</div>
                <div class="card-body text-center">
                    <h3>₱{{ number_format($costPerEmp, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Monthly Breakdown</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr><th>Month</th><th>Payroll</th><th>Overtime</th></tr>
                </thead>
                <tbody>
                    @forelse($costData as $row)
                    <tr>
                        <td>{{ $row->month ?? '-' }}</td>
                        <td>₱{{ number_format($row->total_payroll ?? 0, 2) }}</td>
                        <td>₱{{ number_format($row->total_overtime ?? 0, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center">No data yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <a href="{{ route('hr.hr4.analytics.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
