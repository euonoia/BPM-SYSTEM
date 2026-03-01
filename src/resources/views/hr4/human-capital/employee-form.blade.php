@extends('layouts.hr4.app')

@section('title', ($is_new ? 'New' : 'Update') . ' Employee - HR4')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.index') }}">HR4</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hr.hr4.human-capital.index') }}">Human Capital</a></li>
            <li class="breadcrumb-item active">{{ $is_new ? 'New' : 'Update' }}</li>
        </ol>
    </nav>

    <h2>Step 2: {{ $is_new ? 'Create New Employee' : 'Update Record' }}</h2>

    <form action="{{ route('hr.hr4.human-capital.save') }}" method="POST">
        @csrf
        <input type="hidden" name="is_new" value="{{ $is_new ? '1' : '0' }}">
        
        <!-- Basic Info -->
        <div class="card mb-3">
            <div class="card-header">Basic Information</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Employee ID *</label>
                        <input type="text" name="employee_id" class="form-control" value="{{ $data['employee_id'] ?? '' }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>First Name *</label>
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $data['first_name'] ?? '') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Last Name *</label>
                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $data['last_name'] ?? '') }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $data['email'] ?? '') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <!-- Employment -->
        <div class="card mb-3">
            <div class="card-header">Employment Details</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label>Department *</label>
                        <select name="department" class="form-control" required>
                            <option value="">Select</option>
                            @foreach(['HR', 'Finance', 'Operations', 'IT', 'Nursing', 'Medical', 'Administration'] as $dept)
                            <option value="{{ $dept }}" {{ old('department', $data['department'] ?? '') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Position *</label>
                        <input type="text" name="position" class="form-control" value="{{ old('position', $data['position'] ?? '') }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Basic Salary *</label>
                        <input type="number" name="basic_salary" class="form-control" value="{{ old('basic_salary', $data['basic_salary'] ?? '') }}" step="0.01" required>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            {{ $is_new ? 'Create' : 'Update' }} Record
        </button>
        <a href="{{ route('hr.hr4.human-capital.process') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection