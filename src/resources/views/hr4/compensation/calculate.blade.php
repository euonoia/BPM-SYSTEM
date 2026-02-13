@extends('layouts.hr4.app')

@section('title', 'Compensation Calculation - HR4')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.index') }}">HR4</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.compensation.index') }}">Compensation</a></li>
            <li class="breadcrumb-item active">Calculation</li>
        </ol>
    </nav>

    <h2>Step 3: Propose Adjustment / Incentive</h2>
    
    <div class="row">
        <!-- Employee Info -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">Employee Details</div>
                <div class="card-body">
                    <h5>{{ $data['employee_name'] }}</h5>
                    <p>ID: {{ $data['employee_id'] }}</p>
                    <p>Current Grade: {{ $data['current_grade'] }}</p>
                    <p>Years in Position: {{ $data['years_in_position'] }}</p>
                    <hr>
                    <h6>Performance</h6>
                    <p>Rating: {{ $data['performance_rating'] }}/5</p>
                    <p>KPI: {{ $data['kpi_achievement'] }}%</p>
                </div>
            </div>
        </div>

        <!-- Calculation -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">Compensation Calculation</div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td>Current Basic Salary</td>
                            <td class="text-end">₱{{ number_format($data['current_salary'], 2) }}</td>
                        </tr>
                        
                        @if($adjustment['promotion_raise'] > 0)
                        <tr class="table-success">
                            <td>Promotion Raise (Grade {{ $data['current_grade'] }} → {{ $data['proposed_grade'] }})</td>
                            <td class="text-end">+ ₱{{ number_format($adjustment['promotion_raise'], 2) }}</td>
                        </tr>
                        @endif
                        
                        @if($adjustment['performance_bonus'] > 0)
                        <tr class="table-success">
                            <td>Performance Bonus (Rating: {{ $data['performance_rating'] }})</td>
                            <td class="text-end">+ ₱{{ number_format($adjustment['performance_bonus'], 2) }}</td>
                        </tr>
                        @endif
                        
                        @if($adjustment['kpi_incentive'] > 0)
                        <tr class="table-success">
                            <td>KPI Achievement Incentive ({{ $data['kpi_achievement'] }}%)</td>
                            <td class="text-end">+ ₱{{ number_format($adjustment['kpi_incentive'], 2) }}</td>
                        </tr>
                        @endif
                        
                        @if($adjustment['longevity_bonus'] > 0)
                        <tr class="table-success">
                            <td>Longevity Bonus ({{ $data['years_in_position'] }} years)</td>
                            <td class="text-end">+ ₱{{ number_format($adjustment['longevity_bonus'], 2) }}</td>
                        </tr>
                        @endif
                        
                        <tr class="table-primary">
                            <th>Proposed New Salary</th>
                            <th class="text-end">₱{{ number_format($adjustment['new_salary'], 2) }}</th>
                        </tr>
                        
                        <tr class="table-warning">
                            <th>Total Increase</th>
                            <th class="text-end text-success">
                                + ₱{{ number_format($adjustment['total_increase'], 2) }}
                                ({{ number_format($adjustment['increase_percentage'], 2) }}%)
                            </th>
                        </tr>
                    </table>

                    @if($adjustment['total_increase'] > 0)
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> 
                            <strong>Recommendation:</strong> Approve salary adjustment
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> 
                            <strong>Recommendation:</strong> Maintain current salary (no adjustment needed)
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card mt-3">
                <div class="card-header">Approval Workflow</div>
                <div class="card-body text-center">
                    <form action="{{ route('hr.hr4.compensation.submit') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="action" value="approve">
                        <button type="submit" class="btn btn-success btn-lg me-2">
                            <i class="bi bi-check-circle"></i> Submit for Approval
                        </button>
                    </form>
                    
                    <form action="{{ route('hr.hr4.compensation.submit') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="action" value="modify">
                        <button type="submit" class="btn btn-warning btn-lg me-2">
                            <i class="bi bi-pencil"></i> Modify
                        </button>
                    </form>
                    
                    <a href="{{ route('hr.hr4.compensation.index') }}" class="btn btn-secondary btn-lg">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection