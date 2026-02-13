@extends('layouts.hr4.app')

@section('title', 'Compensation Validation - HR4')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.index') }}">HR4</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.compensation.index') }}">Compensation</a></li>
            <li class="breadcrumb-item active">Validation</li>
        </ol>
    </nav>

    <h2>Step 2: Data Validation</h2>
    
    <div class="card {{ $is_complete ? 'border-success' : 'border-danger' }}">
        <div class="card-header {{ $is_complete ? 'bg-success' : 'bg-danger' }} text-white">
            Validation Result: {{ $is_complete ? 'COMPLETE' : 'INCOMPLETE' }}
        </div>
        <div class="card-body">
            <h5>Job Grade & Performance Data Check</h5>
            
            <table class="table table-bordered">
                <tr>
                    <td>Employee ID</td>
                    <td>{{ $data['employee_id'] ?? 'N/A' }}</td>
                    <td>
                        <span class="badge {{ !empty($data['employee_id']) ? 'bg-success' : 'bg-danger' }}">
                            {{ !empty($data['employee_id']) ? '✓' : '✗' }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>Job Grade</td>
                    <td>Grade {{ $data['current_grade'] ?? 'N/A' }}</td>
                    <td>
                        <span class="badge {{ !empty($data['current_grade']) ? 'bg-success' : 'bg-danger' }}">
                            {{ !empty($data['current_grade']) ? '✓' : '✗' }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>Current Salary</td>
                    <td>₱{{ number_format($data['current_salary'] ?? 0, 2) }}</td>
                    <td>
                        <span class="badge {{ ($data['current_salary'] ?? 0) > 0 ? 'bg-success' : 'bg-danger' }}">
                            {{ ($data['current_salary'] ?? 0) > 0 ? '✓' : '✗' }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>Performance Rating</td>
                    <td>{{ $data['performance_rating'] ?? 'N/A' }} / 5</td>
                    <td>
                        <span class="badge {{ !empty($data['performance_rating']) ? 'bg-success' : 'bg-danger' }}">
                            {{ !empty($data['performance_rating']) ? '✓' : '✗' }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>KPI Achievement</td>
                    <td>{{ $data['kpi_achievement'] ?? 0 }}%</td>
                    <td>
                        <span class="badge {{ ($data['kpi_achievement'] ?? 0) > 0 ? 'bg-success' : 'bg-danger' }}">
                            {{ ($data['kpi_achievement'] ?? 0) > 0 ? '✓' : '✗' }}
                        </span>
                    </td>
                </tr>
            </table>

            @if($is_complete)
                <div class="alert alert-success">
                    <strong>✓ Data Complete!</strong> Proceed to compensation calculation.
                </div>
                <a href="{{ route('hr.hr4.compensation.calculate') }}" class="btn btn-success btn-lg">
                    <i class="bi bi-calculator"></i> Calculate Compensation
                </a>
            @else
                <div class="alert alert-danger">
                    <strong>✗ Data Incomplete!</strong> Please provide missing information.
                </div>
                <a href="{{ route('hr.hr4.compensation.input') }}" class="btn btn-warning btn-lg">
                    <i class="bi bi-arrow-left"></i> Request Correction
                </a>
            @endif
        </div>
    </div>
</div>
@endsection