@extends('core1.layouts.app')

@section('title', 'Patient Management')

@section('content')
<div class="core1-container">
    @if(session('success'))
        <div class="alert alert-success d-flex items-center gap-2" role="alert">
            <i class="fas fa-check-circle"></i>
            <p class="m-0">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error d-flex items-center gap-2" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            <p class="m-0">{{ session('error') }}</p>
        </div>
    @endif

   <div class="core1-flex-between core1-header">
    <div>
        <h2 class="core1-title">Patient Management</h2>
        <p class="core1-subtitle">Manage patient records and registrations</p>
    </div>

    {{-- Only show New Patient button for Admin and Receptionist --}}
    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'receptionist')
        <a href="{{ route('core1.patients.create') }}" class="core1-btn core1-btn-primary">
            <i class="fas fa-plus"></i>
            <span class="pl-20">New Patient</span>
        </a>
    @endif
</div>


    <div class="core1-stats-grid">
        <div class="core1-stat-card">
            <div>
                <p class="text-sm text-gray mb-5">Total Patients</p>
                <p class="core1-title">{{ $stats['total'] }}</p>
            </div>
            <div class="core1-icon-box core1-icon-blue">
                <i class="fas fa-users"></i>
            </div>
        </div>
        
        <div class="core1-stat-card">
            <div>
                <p class="text-sm text-gray mb-5">Active Patients</p>
                <p class="core1-title text-green">{{ $stats['active'] }}</p>
            </div>
            <div class="core1-icon-box core1-icon-green">
                <i class="fas fa-user-check"></i>
            </div>
        </div>
        
        <div class="core1-stat-card">
            <div>
                <p class="text-sm text-gray mb-5">New Today</p>
                <p class="core1-title text-purple">{{ $stats['new_today'] }}</p>
            </div>
            <div class="core1-icon-box core1-icon-purple">
                <i class="fas fa-user-plus"></i>
            </div>
        </div>
        
        <div class="core1-stat-card">
            <div>
                <p class="text-sm text-gray mb-5">This Month</p>
                <p class="core1-title text-orange">{{ $stats['new_this_month'] }}</p>
            </div>
            <div class="core1-icon-box core1-icon-orange">
                <i class="fas fa-calendar-alt"></i>
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('core1.patients.index') }}" class="core1-search-form">
        <div class="core1-search-input-wrapper">
            <i class="fas fa-search core1-search-icon"></i>
            <input
                type="text"
                name="search"
                value="{{ $searchTerm }}"
                placeholder="Search by name, patient ID, or email..."
                class="core1-search-input"
            >
        </div>
        <select name="status" class="core1-input w-auto m-0">
            <option value="">All Status</option>
            <option value="active" {{ $statusFilter === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ $statusFilter === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        <button type="submit" class="core1-btn core1-btn-primary">
            <i class="fas fa-search"></i>
            <span class="pl-20">Search</span>
        </button>
        @if($searchTerm || $statusFilter)
            <a href="{{ route('core1.patients.index') }}" class="core1-btn core1-btn-outline">
                <i class="fas fa-times"></i>
                <span class="pl-20">Clear</span>
            </a>
        @endif
    </form>

    <div class="core1-table-container">
        <table class="core1-table">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Contact Info</th>
                    <th>Age/Gender</th>
                    <th>Assigned Nurse</th>
                    @if(auth()->user()->role !== 'doctor')
                        <th>Assigned Doctor</th>
                    @endif
                    <th>Last Visit</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                    <tr>
                        <td>
                            <div class="d-flex items-center gap-3">
                                <div class="core1-avatar">
                                    {{ strtoupper(substr($patient->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-dark">{{ $patient->name }}</div>
                                    <div class="text-xs text-gray font-mono">{{ $patient->patient_id }}</div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="text-sm text-dark d-flex items-center gap-2">
                                <i class="fas fa-phone text-xs text-gray"></i>
                                {{ $patient->phone }}
                            </div>
                            <div class="text-sm text-gray d-flex items-center gap-2 mt-4">
                                <i class="fas fa-envelope text-xs text-gray"></i>
                                {{ $patient->email }}
                            </div>
                        </td>

                        <td>
                            <div class="d-flex items-center gap-2">
                                <span class="text-sm font-medium text-dark">{{ $patient->age ?? 'N/A' }}</span>
                                <span class="text-gray">|</span>
                                <span class="text-sm text-gray text-capitalize">{{ $patient->gender }}</span>
                            </div>
                        </td>

     <td>
    @if(auth()->user()->role === 'admin')
        {{-- Admin: show nurse name only, read-only --}}
        <div class="text-sm text-dark">
            {{ $patient->assignedNurse->name ?? 'Not Admitted' }}
        </div>
    @elseif(auth()->user()->isHeadNurse() && $patient->care_type)
        {{-- Head Nurse: keep editable dropdown --}}
        <form action="{{ route('core1.patients.assign-nurse', $patient) }}" method="POST" class="m-0 d-flex gap-2">
            @csrf
            <select name="nurse_id" onchange="this.form.submit()" class="core1-input text-xs w-auto py-5 px-10 m-0">
                <option value="">-- Assign Nurse --</option>
                @foreach($nurses as $nurse)
                    <option value="{{ $nurse->id }}" {{ $patient->assigned_nurse_id == $nurse->id ? 'selected' : '' }}>
                        {{ $nurse->name }}
                    </option>
                @endforeach
            </select>
        </form>
    @else
        {{-- Nurse or others: show assigned nurse without PRIORITY --}}
        <div class="text-sm text-dark">
            {{ $patient->assignedNurse->name ?? 'Not Admitted' }}
        </div>
    @endif
</td>


                        @if(auth()->user()->role !== 'doctor')
                            <td>
                                @php
                                    $doctor = $patient->appointments()->latest()->first()?->doctor;
                                @endphp
                                <div class="text-sm text-dark">
                                    {{ $doctor->name ?? 'Not Assigned' }}
                                </div>
                            </td>
                        @endif

                        <td>
                            <div class="text-sm text-dark">
                                {{ $patient->last_visit ? $patient->last_visit->format('M d, Y') : 'Never' }}
                            </div>
                            @if($patient->last_visit)
                                <div class="text-xs text-gray mt-4">
                                    {{ $patient->last_visit->diffForHumans() }}
                                </div>
                            @endif
                        </td>

                        <td>
    @php
        $isPriority = auth()->user()->role === 'nurse' && $patient->assigned_nurse_id === auth()->user()->id;
    @endphp
    <span class="core1-badge {{ $patient->status === 'active' ? 'core1-badge-active' : 'core1-badge-inactive' }}">
        <i class="fas fa-circle text-xxs"></i>
        <span class="pl-20">
            {{ ucfirst($patient->status) }} 
            @if($isPriority)
                (PRIORITY)
            @endif
        </span>
    </span>
</td>

                        {{-- ACTIONS --}}
<td>
   @php
    $hasAppointment = $patient->appointments()
        ->whereIn('status', ['scheduled', 'accepted'])
        ->exists();
    $canMovePatient = in_array(auth()->user()->role, ['admin', 'doctor']);
    $isAdmin = auth()->user()->role === 'admin';
@endphp

{{-- Admin view: show actions if patient has appointment OR already admitted --}}
@if(!$isAdmin || ($isAdmin && ($hasAppointment || $patient->care_type)) || auth()->user()->role === 'doctor')
    <div class="d-flex items-center justify-center gap-2">
        {{-- View --}}
        <a href="{{ route('core1.patients.show', $patient) }}" 
           class="core1-icon-action text-blue"
           title="View Details">
            <i class="fas fa-eye"></i>
        </a>

        {{-- Edit --}}
        @if(auth()->user()->role !== 'doctor')
            <a href="{{ route('core1.patients.edit', $patient) }}" 
               class="core1-icon-action text-orange"
               title="Edit Patient">
                <i class="fas fa-edit"></i>
            </a>
        @endif

        {{-- Book Appointment --}}
        <a href="{{ route('core1.appointments.create', ['patient_id' => $patient->id]) }}" 
           class="core1-icon-action text-purple"
           title="Book Appointment">
            <i class="fas fa-calendar-plus"></i>
        </a>

        {{-- Delete --}}
        @if(auth()->user()->role !== 'doctor')
            <form action="{{ route('core1.patients.destroy', $patient) }}" 
                  method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this patient? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button class="core1-icon-action text-red">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        @endif

        {{-- Move to Inpatient/Outpatient --}}
        @if($canMovePatient && !$patient->care_type)
            <form method="POST" action="{{ route('core1.patients.move', $patient) }}" class="d-flex gap-1">
                @csrf
                <input type="hidden" name="care_type" value="inpatient">
                <input type="hidden" name="admission_date" value="{{ now()->toDateString() }}">
                <input type="hidden" name="doctor_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="reason" value="Routine Checkup">
                <button class="core1-btn-sm core1-btn-outline">Move to Inpatient</button>
            </form>

            <form method="POST" action="{{ route('core1.patients.move', $patient) }}" class="d-flex gap-1">
                @csrf
                <input type="hidden" name="care_type" value="outpatient">
                <input type="hidden" name="admission_date" value="{{ now()->toDateString() }}">
                <input type="hidden" name="doctor_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="reason" value="Routine Checkup">
                <button class="core1-btn-sm core1-btn-outline">Move to Outpatient</button>
            </form>
        @elseif($patient->care_type)
            <span class="core1-badge {{ $patient->care_type === 'inpatient' ? 'core1-badge-active' : 'core1-badge-inactive' }}">
                {{ strtoupper($patient->care_type) }}
            </span>
        @endif
    </div>
@else
    {{-- Admin view, patient not scheduled and not admitted --}}
    @if($isAdmin && !$hasAppointment && !$patient->care_type)
        <span class="text-gray text-xs">No actions available</span>
    @endif
@endif

</td>


                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center p-40">
                            <div class="d-flex flex-col items-center justify-center">
                                <div class="icon-box-large">
                                    <i class="fas fa-user-slash"></i>
                                </div>
                                <p class="text-dark font-medium text-lg">No patients found</p>
                                <p class="text-gray text-sm mb-5">
                                    @if($searchTerm || $statusFilter)
                                        Try adjusting your search or filters
                                    @elseif(auth()->user()->role !== 'doctor')
                                        Get started by adding a new patient
                                    @endif
                                </p>

                                @if(!$searchTerm && !$statusFilter && auth()->user()->role !== 'doctor')
                                    <a href="{{ route('core1.patients.create') }}" class="core1-btn core1-btn-primary">
                                        <i class="fas fa-plus"></i>
                                        <span class="pl-20">Add First Patient</span>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($patients->hasPages())
        <div class="d-flex justify-between items-center mt-25">
            <div class="text-sm text-gray">
                Showing {{ $patients->firstItem() }} to {{ $patients->lastItem() }} of {{ $patients->total() }} patients
            </div>
            <div>
                {{ $patients->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
