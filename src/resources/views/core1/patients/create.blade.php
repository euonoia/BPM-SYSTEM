@extends('core1.layouts.app')

@section('title', 'Register New Patient')

@section('content')
<div class="core1-container">
    <div class="core1-header">
        <h1 class="core1-title">Register New Patient</h1>
        <p class="core1-subtitle">Add a new patient to the system</p>
    </div>

    <div class="core1-card core1-card-compact">
        <form action="{{ route('patients.store') }}" method="POST">
            @csrf
            
            <div class="core1-form-grid">
                <div class="core1-form-group">
                    <label for="name" class="core1-label">Full Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="core1-input @error('name') core1-input-error @enderror">
                    @error('name')
                        <p class="core1-error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="core1-form-group">
                    <label for="date_of_birth" class="core1-label">Date of Birth *</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required
                           class="core1-input @error('date_of_birth') core1-input-error @enderror">
                    @error('date_of_birth')
                        <p class="core1-error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="core1-form-group">
                    <label for="gender" class="core1-label">Gender *</label>
                    <select id="gender" name="gender" required
                            class="core1-input @error('gender') core1-input-error @enderror">
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender') === 'male' || old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') === 'female' || old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender') === 'other' || old('gender') === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                        <p class="core1-error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="core1-form-group">
                    <label for="phone" class="core1-label">Phone Number *</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                           class="core1-input @error('phone') core1-input-error @enderror">
                    @error('phone')
                        <p class="core1-error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="core1-form-group">
                    <label for="email" class="core1-label">Email Address *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="core1-input @error('email') core1-input-error @enderror">
                    @error('email')
                        <p class="core1-error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="core1-form-group">
                    <label for="address" class="core1-label">Address</label>
                    <input type="text" id="address" name="address" value="{{ old('address') }}"
                           class="core1-input">
                </div>
            </div>

            <div class="core1-form-actions">
                <button type="submit" class="core1-btn core1-btn-primary">
                    Register Patient
                </button>
                <a href="{{ route('patients.index') }}" class="core1-btn core1-btn-outline">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


