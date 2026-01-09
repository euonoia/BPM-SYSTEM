@extends('core1.layouts.app')

@section('title', 'Appointments')

@section('content')
<div class="core1-container">
    <div class="core1-flex-between core1-header">
        <div>
            <h1 class="core1-title">
                {{ $view === 'patients' ? 'Patient Management' : 'Appointments' }}
            </h1>
            <p class="core1-subtitle">
                {{ $view === 'patients' ? 'Manage registered patients' : 'Manage and schedule appointments' }}
            </p>
        </div>
        @if($view === 'patients')
            <a href="{{ route('patients.create') }}" class="core1-btn core1-btn-primary">
                <i class="fas fa-plus"></i>
                <span class="pl-20">Add Patient</span>
            </a>
        @else
            <a href="{{ route('appointments.create') }}" class="core1-btn core1-btn-primary">
                <i class="fas fa-plus"></i>
                <span class="pl-20">Book Appointment</span>
            </a>
        @endif
    </div>

    <!-- View Controls -->
    <div class="core1-card mb-30">
        <div class="core1-flex-between">
            <div class="core1-flex-gap-2">
                <a href="?view={{ $view }}&date={{ date('Y-m', strtotime($currentDate . ' -1 month')) }}" class="core1-btn core1-btn-outline" style="padding: 8px;">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <h2 class="core1-title" style="font-size: 20px;">
                    {{ date('F Y', strtotime($currentDate)) }}
                </h2>
                <a href="?view={{ $view }}&date={{ date('Y-m', strtotime($currentDate . ' +1 month')) }}" class="core1-btn core1-btn-outline" style="padding: 8px;">
                    <i class="fas fa-chevron-right"></i>
                </a>
                <a href="?view={{ $view }}&date={{ date('Y-m') }}" class="core1-btn core1-btn-outline">
                    Today
                </a>
            </div>
            <div class="core1-flex-gap-2">
                @foreach(['month', 'week', 'day', 'list', 'patients'] as $v)
                    <a href="?view={{ $v }}&date={{ $currentDate }}" 
                       class="core1-btn {{ $view === $v ? 'core1-btn-primary' : 'core1-btn-outline' }}"
                       style="text-transform: capitalize;">
                        {{ $v }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- List View -->
    @if($view === 'list')
        <div class="core1-table-container">
            <table class="core1-table">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr>
                            <td>
                                <div class="core1-flex-gap-2">
                                    <i class="fas fa-calendar text-gray"></i>
                                    <div>
                                        <div class="text-sm font-medium text-dark">
                                            {{ $appointment->appointment_date->format('M d, Y') }}
                                        </div>
                                        <div class="text-xs text-gray">{{ $appointment->appointment_time }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="core1-flex-gap-2">
                                    <i class="fas fa-user text-gray"></i>
                                    <div>
                                        <div class="text-sm font-medium text-dark">{{ $appointment->patient->name }}</div>
                                        <div class="text-xs text-gray">{{ $appointment->patient->patient_id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm text-dark">{{ $appointment->doctor->name }}</div>
                            </td>
                            <td>
                                <div class="text-sm text-dark">{{ $appointment->type }}</div>
                            </td>
                            <td>
                                <span class="core1-badge {{ 
                                    $appointment->status === 'completed' ? 'core1-badge-active' :
                                    ($appointment->status === 'cancelled' ? 'core1-badge-inactive' :
                                    'core1-badge-inactive')
                                }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex items-center justify-center gap-2">
                                    <a href="{{ route('appointments.show', $appointment) }}" class="btn-icon-action text-blue-500">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="d-flex m-0 bg-transparent">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon-action text-red-600">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-40 text-gray">No appointments found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @elseif($view === 'patients')
        <div class="core1-table-container">
            <table class="core1-table">
                <thead>
                    <tr>
                        <th>Patient Details</th>
                        <th>Contact Information</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                        <tr>
                            <td>
                                <div class="d-flex items-center gap-3">
                                    <div class="avatar">
                                        {{ substr($patient->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-dark">{{ $patient->name }}</div>
                                        <div class="text-xs text-gray">ID: {{ $patient->patient_id ?? '#' . $patient->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm text-dark"><i class="fas fa-envelope text-gray mr-2"></i>{{ $patient->email }}</div>
                                <div class="text-sm text-gray"><i class="fas fa-phone text-gray mr-2"></i>{{ $patient->phone }}</div>
                            </td>
                            <td>
                                <span class="core1-badge core1-badge-active">Active</span>
                            </td>
                            <td>
                                <div class="d-flex items-center justify-center gap-2">
                                    <a href="{{ route('patients.show', $patient->id) }}" class="btn-icon-action text-blue-500">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('patients.edit', $patient->id) }}" class="btn-icon-action text-yellow-600">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center p-40 text-gray">
                                No patients found. Click "Add Patient" to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @else
        <div class="core1-card">
            <p class="text-center text-gray">Calendar view implementation would go here</p>
        </div>
    @endif
</div>
@endsection


