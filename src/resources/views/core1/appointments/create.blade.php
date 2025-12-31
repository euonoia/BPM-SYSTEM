@extends('core1.layouts.app')

@section('title', 'Book Appointment')

@section('content')
<div class="p-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Book Appointment</h1>
        <p class="text-gray-600 mt-1">Schedule a new appointment</p>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 max-w-2xl">
        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-2">Patient *</label>
                    <select id="patient_id" name="patient_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id || request('patient_id') == $patient->id ? 'selected' : '' }}>
                                {{ $patient->name }} ({{ $patient->patient_id }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-2">Doctor *</label>
                    <select id="doctor_id" name="doctor_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Doctor</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->name }} @if($doctor->specialization)({{ $doctor->specialization }})@endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-2">Date *</label>
                        <input type="date" id="appointment_date" name="appointment_date" value="{{ old('appointment_date') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="appointment_time" class="block text-sm font-medium text-gray-700 mb-2">Time *</label>
                        <input type="time" id="appointment_time" name="appointment_time" value="{{ old('appointment_time') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Appointment Type *</label>
                    <select id="type" name="type" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Type</option>
                        <option value="Consultation" {{ old('type') === 'Consultation' ? 'selected' : '' }}>Consultation</option>
                        <option value="Follow-up" {{ old('type') === 'Follow-up' ? 'selected' : '' }}>Follow-up</option>
                        <option value="Check-up" {{ old('type') === 'Check-up' ? 'selected' : '' }}>Check-up</option>
                        <option value="Emergency" {{ old('type') === 'Emergency' ? 'selected' : '' }}>Emergency</option>
                    </select>
                </div>

                <div>
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">Reason</label>
                    <textarea id="reason" name="reason" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('reason') }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Book Appointment
                </button>
                <a href="{{ route('appointments.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

