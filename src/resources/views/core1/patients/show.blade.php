@extends('layouts.app')

@section('title', 'Patient Details')

@section('content')
<div class="p-8">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Patient Details</h1>
                <p class="text-gray-600 mt-1">View patient information</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('patients.edit', $patient) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Edit Patient
                </a>
                <a href="{{ route('patients.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Patient ID</label>
                <p class="text-gray-900 font-semibold">{{ $patient->patient_id }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <p class="text-gray-900 font-semibold">{{ $patient->name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                <p class="text-gray-900">{{ $patient->date_of_birth->format('M d, Y') }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Age</label>
                <p class="text-gray-900">{{ $patient->age ?? 'N/A' }} years</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                <p class="text-gray-900">{{ $patient->gender }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                <p class="text-gray-900">{{ $patient->phone }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <p class="text-gray-900">{{ $patient->email }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ 
                    $patient->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' 
                }}">
                    {{ $patient->status }}
                </span>
            </div>
            @if($patient->address)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                <p class="text-gray-900">{{ $patient->address }}</p>
            </div>
            @endif
            @if($patient->blood_type)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Blood Type</label>
                <p class="text-gray-900">{{ $patient->blood_type }}</p>
            </div>
            @endif
            @if($patient->allergies)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Allergies</label>
                <p class="text-gray-900">{{ $patient->allergies }}</p>
            </div>
            @endif
            @if($patient->last_visit)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Last Visit</label>
                <p class="text-gray-900">{{ $patient->last_visit->format('M d, Y') }}</p>
            </div>
            @endif
        </div>
    </div>

    <div class="mt-6 flex gap-4">
        <a href="{{ route('appointments.create', ['patient_id' => $patient->id]) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            Book Appointment
        </a>
        <a href="{{ route('medical-records.index', ['patient' => $patient->id]) }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
            View Medical Records
        </a>
    </div>
</div>
@endsection

