@extends('core1.layouts.app')

@section('title', 'Edit Patient')

@section('content')
@extends('core1.layouts.app')

@section('title', 'Edit Patient')

@section('content')
@extends('core1.layouts.app')

@section('title', 'Edit Patient')

@section('content')
<div class="container-padding">
    <div class="header">
        <h2>Edit Patient</h2>
        <p>Update patient information</p>
    </div>

    <div class="card no-hover text-left max-w-900">
        <form action="{{ route('patients.update', $patient) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid-2-col">
                <div>
                    <h3>Full Name *</h3>
                    <input type="text" id="name" name="name" value="{{ old('name', $patient->name) }}" required
                           class="form-input {{ $errors->has('name') ? 'form-input-error' : '' }}">
                    @error('name')
                        <p class="text-red text-sm mt-4">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <h3>Date of Birth *</h3>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $patient->date_of_birth->format('Y-m-d')) }}" required
                           class="form-input {{ $errors->has('date_of_birth') ? 'form-input-error' : '' }}">
                    @error('date_of_birth')
                        <p class="text-red text-sm mt-4">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <h3>Gender *</h3>
                    <select id="gender" name="gender" required
                            class="form-input {{ $errors->has('gender') ? 'form-input-error' : '' }}">
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender', strtolower($patient->gender)) === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', strtolower($patient->gender)) === 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender', strtolower($patient->gender)) === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                        <p class="text-red text-sm mt-4">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <h3>Phone Number *</h3>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $patient->phone) }}" required
                           class="form-input {{ $errors->has('phone') ? 'form-input-error' : '' }}">
                    @error('phone')
                        <p class="text-red text-sm mt-4">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2">
                    <h3>Email Address *</h3>
                    <input type="email" id="email" name="email" value="{{ old('email', $patient->email) }}" required
                           class="form-input {{ $errors->has('email') ? 'form-input-error' : '' }}">
                    @error('email')
                        <p class="text-red text-sm mt-4">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2">
                    <h3>Address</h3>
                    <input type="text" id="address" name="address" value="{{ old('address', $patient->address) }}" class="form-input">
                </div>
            </div>

            <div class="d-flex gap-4 mt-25">
                <button type="submit" class="btn btn-primary">
                    Update Patient
                </button>
                <a href="{{ route('patients.show', $patient) }}" class="btn btn-outline">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
@endsection

