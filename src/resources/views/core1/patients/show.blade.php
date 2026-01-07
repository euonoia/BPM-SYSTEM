@extends('core1.layouts.app')

@section('title', 'Patient Details')

@section('content')
<div class="container-padding">
    <div class="header d-flex justify-between items-center mb-25">
        <div>
            <h2>Patient Details</h2>
            <p>View patient information</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('patients.edit', $patient) }}" class="btn btn-primary d-flex items-center gap-2">
                <i class="fas fa-edit"></i>
                <span>Edit Patient</span>
            </a>
            <form action="{{ route('patients.destroy', $patient) }}" method="POST" class="d-flex m-0" onsubmit="return confirm('Are you sure you want to delete this patient? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger d-flex items-center gap-2">
                    <i class="fas fa-trash"></i>
                    <span>Delete Patient</span>
                </button>
            </form>
            <a href="{{ route('patients.index') }}" class="btn btn-outline d-flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <span>Back to List</span>
            </a>
        </div>
    </div>

    <div class="card no-hover text-left max-w-900">
        <div class="grid-2-col">
            <div>
                <h3>Patient ID</h3>
                <p>{{ $patient->patient_id }}</p>
            </div>
            <div>
                <h3>Name</h3>
                <p>{{ $patient->name }}</p>
            </div>
            <div>
                <h3>Date of Birth</h3>
                <p>{{ $patient->date_of_birth->format('M d, Y') }}</p>
            </div>
            <div>
                <h3>Age</h3>
                <p>{{ $patient->age ?? 'N/A' }} years</p>
            </div>
            <div>
                <h3>Gender</h3>
                <p>{{ ucfirst($patient->gender) }}</p>
            </div>
            <div>
                <h3>Phone</h3>
                <p>{{ $patient->phone }}</p>
            </div>
            <div>
                <h3>Email</h3>
                <p>{{ $patient->email }}</p>
            </div>
            <div>
                <h3>Status</h3>
                <span class="badge {{ $patient->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                    {{ ucfirst($patient->status) }}
                </span>
            </div>
            @if($patient->address)
            <div class="col-span-2">
                <h3>Address</h3>
                <p>{{ $patient->address }}</p>
            </div>
            @endif
            @if($patient->blood_type)
            <div>
                <h3>Blood Type</h3>
                <p>{{ $patient->blood_type }}</p>
            </div>
            @endif
            @if($patient->allergies)
            <div>
                <h3>Allergies</h3>
                <p>{{ $patient->allergies }}</p>
            </div>
            @endif
            @if($patient->last_visit)
            <div>
                <h3>Last Visit</h3>
                <p>{{ $patient->last_visit->format('M d, Y') }}</p>
            </div>
            @endif
        </div>
    </div>

    <div class="d-flex gap-4 mt-25">
        <a href="{{ route('appointments.create', ['patient_id' => $patient->id]) }}" class="btn btn-success d-flex items-center gap-2">
            <i class="fas fa-calendar-plus"></i>
            <span>Book Appointment</span>
        </a>
        <a href="{{ route('medical-records.index', ['patient' => $patient->id]) }}" class="btn icon-purple d-flex items-center gap-2 text-purple-600 bg-transparent border-none">
            <i class="fas fa-file-medical"></i>
            <span>View Medical Records</span>
        </a>
    </div>
</div>
@endsection

