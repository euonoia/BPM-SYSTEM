@extends('layouts.hr4.app')

@section('title', 'Validation - HR4')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.index') }}">HR4</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.human-capital.index') }}">Human Capital</a></li>
            <li class="breadcrumb-item active">Validation</li>
        </ol>
    </nav>

    <h2>Step 3: Check Record Completeness</h2>

    <div class="card {{ $is_complete ? 'border-success' : 'border-danger' }}">
        <div class="card-header {{ $is_complete ? 'bg-success' : 'bg-danger' }} text-white">
            {{ $is_complete ? 'COMPLETE' : 'INCOMPLETE' }}
        </div>
        <div class="card-body">
            <h5>{{ $employee['first_name'] }} {{ $employee['last_name'] }}</h5>
            
            <table class="table">
                <tr>
                    <td>ID</td>
                    <td>{{ $employee['employee_id'] }}</td>
                    <td>{!! !empty($employee['employee_id']) ? '✅' : '❌' !!}</td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td>{{ $employee['first_name'] }} {{ $employee['last_name'] }}</td>
                    <td>{!! !empty($employee['first_name']) ? '✅' : '❌' !!}</td>
                </tr>
                <tr>
                    <td>Department</td>
                    <td>{{ $employee['department'] }}</td>
                    <td>{!! !empty($employee['department']) ? '✅' : '❌' !!}</td>
                </tr>
                <tr>
                    <td>Salary</td>
                    <td>₱{{ number_format($employee['basic_salary'] ?? 0, 2) }}</td>
                    <td>{!! ($employee['basic_salary'] ?? 0) > 0 ? '✅' : '❌' !!}</td>
                </tr>
            </table>

            @if($is_complete)
                <div class="alert alert-success">✓ Ready to save!</div>
                <form action="{{ route('hr.hr4.human-capital.confirm-save') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">Save to Database</button>
                </form>
                <a href="{{ route('hr.hr4.human-capital.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <a href="{{ route('hr.hr4.payroll.index') }}" class="btn btn-primary">Go to Payroll</a>
            @else
                <div class="alert alert-warning">⚠ Missing information!</div>
                <a href="{{ route('hr.hr4.human-capital.edit') }}" class="btn btn-warning">Add Info</a>
            @endif
        </div>
    </div>
</div>
@endsection