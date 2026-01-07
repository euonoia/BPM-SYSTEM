@extends('core1.layouts.app')

@section('title', 'Patient Management')

@section('content')
<div class="container-padding">
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

    <!-- Header -->
    <div class="header d-flex justify-between items-center mb-25">
        <div>
            <h2>Patient Management</h2>
            <p>Manage patient records and registrations</p>
        </div>
        <a href="{{ route('patients.create') }}" class="btn btn-primary d-flex items-center gap-2">
            <i class="fas fa-plus"></i>
            <span>New Patient</span>
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="dashboard-grid mb-30">
        <div class="card no-hover d-flex items-center justify-between text-left p-25">
            <div>
                <p class="text-sm font-medium text-gray mb-5">Total Patients</p>
                <p class="text-dark text-xl">{{ $stats['total'] }}</p>
            </div>
            <div class="icon-box icon-blue">
                <i class="fas fa-users"></i>
            </div>
        </div>
        
        <div class="card no-hover d-flex items-center justify-between text-left p-25">
            <div>
                <p class="text-sm font-medium text-gray mb-5">Active Patients</p>
                <p class="text-green text-xl">{{ $stats['active'] }}</p>
            </div>
            <div class="icon-box icon-green">
                <i class="fas fa-user-check"></i>
            </div>
        </div>
        
        <div class="card no-hover d-flex items-center justify-between text-left p-25">
            <div>
                <p class="text-sm font-medium text-gray mb-5">New Today</p>
                <p class="text-purple text-xl">{{ $stats['new_today'] }}</p>
            </div>
            <div class="icon-box icon-purple">
                <i class="fas fa-user-plus"></i>
            </div>
        </div>
        
        <div class="card no-hover d-flex items-center justify-between text-left p-25">
            <div>
                <p class="text-sm font-medium text-gray mb-5">This Month</p>
                <p class="text-orange text-xl">{{ $stats['new_this_month'] }}</p>
            </div>
            <div class="icon-box icon-orange">
                <i class="fas fa-calendar-alt"></i>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <form method="GET" action="{{ route('patients.index') }}" class="d-flex gap-3 align-center mb-30">
        <div class="search-container flex-1">
            <i class="fas fa-search search-icon"></i>
            <input
                type="text"
                name="search"
                value="{{ $searchTerm }}"
                placeholder="Search by name, patient ID, or email..."
                class="search-input"
            >
        </div>
        <select name="status" class="w-auto m-0">
            <option value="">All Status</option>
            <option value="active" {{ $statusFilter === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ $statusFilter === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        <button type="submit" class="btn btn-primary d-flex items-center gap-2">
            <i class="fas fa-search"></i>
            <span>Search</span>
        </button>
        @if($searchTerm || $statusFilter)
            <a href="{{ route('patients.index') }}" class="btn btn-outline d-flex align-center gap-2">
                <i class="fas fa-times"></i>
                <span>Clear</span>
            </a>
        @endif
    </form>

    <!-- Patient List -->
    <div class="card no-hover p-0 border-none overflow-hidden">
        <div class="overflow-x-auto">
            <table>
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Contact Info</th>
                        <th>Age/Gender</th>
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
                                    <div class="avatar">
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
                                <span class="badge {{ $patient->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                                    <i class="fas fa-circle text-xxs"></i>
                                    {{ ucfirst($patient->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex items-center justify-center gap-2">
                                    <a href="{{ route('patients.show', $patient) }}" 
                                       class="btn-icon-action text-blue-500"
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('patients.edit', $patient) }}" 
                                       class="btn-icon-action text-yellow-600"
                                       title="Edit Patient">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('appointments.create', ['patient_id' => $patient->id]) }}" 
                                       class="btn-icon-action text-purple-600"
                                       title="Book Appointment">
                                        <i class="fas fa-calendar-plus"></i>
                                    </a>
                                    <form action="{{ route('patients.destroy', $patient) }}" 
                                          method="POST" 
                                          class="d-flex m-0 p-0 bg-transparent"
                                          onsubmit="return confirm('Are you sure you want to delete this patient? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn-icon-action text-red-600"
                                                title="Delete Patient">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-40">
                                <div class="d-flex flex-col items-center justify-center">
                                    <div class="icon-box-large">
                                        <i class="fas fa-user-slash"></i>
                                    </div>
                                    <p class="text-dark font-medium text-lg">No patients found</p>
                                    <p class="text-gray text-sm mb-5">
                                        @if($searchTerm || $statusFilter)
                                            Try adjusting your search or filters
                                        @else
                                            Get started by adding a new patient
                                        @endif
                                    </p>
                                    @if(!$searchTerm && !$statusFilter)
                                        <a href="{{ route('patients.create') }}" class="btn btn-primary d-flex items-center gap-2 mt-25">
                                            <i class="fas fa-plus"></i>
                                            <span>Add First Patient</span>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
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
