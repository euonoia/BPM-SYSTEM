@extends('core1.layouts.app')

@section('title', 'Inpatient Management')

@section('content')
<div class="core1-container">
    <div class="core1-flex-between core1-header">
        <div>
            <h1 class="core1-title">Inpatient Care</h1>
            <p class="core1-subtitle">Monitor admissions, bed availability, and patient waiting lists</p>
        </div>
        <div class="core1-flex-gap-2">
            <button class="core1-btn core1-btn-outline">
                <i class="bi bi-printer"></i>
                <span class="ml-10">Export Report</span>
            </button>
            <button class="core1-btn core1-btn-primary">
                <i class="bi bi-plus-lg"></i>
                <span class="ml-10">New Admission</span>
            </button>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="core1-stats-grid">
        <div class="core1-stat-card">
            <div>
                <p class="text-sm text-gray mb-5">Total Admitted</p>
                <p class="core1-title">{{ $stats['total_patients'] }}</p>
            </div>
            <div class="icon-box" style="background: #e0f2fe; color: #0369a1;">
                <i class="bi bi-person-check"></i>
            </div>
        </div>
        
        <div class="core1-stat-card">
            <div>
                <p class="text-sm text-gray mb-5">Admissions Today</p>
                <p class="core1-title text-green">{{ $stats['admissions_today'] }}</p>
            </div>
            <div class="icon-box" style="background: #dcfce7; color: #15803d;">
                <i class="bi bi-box-arrow-in-right"></i>
            </div>
        </div>
        
        <div class="core1-stat-card">
            <div>
                <p class="text-sm text-gray mb-5">Available Beds</p>
                <p class="core1-title text-orange">{{ $stats['available_beds'] }}</p>
            </div>
            <div class="icon-box" style="background: #ffedd5; color: #c2410c;">
                <i class="bi bi-hospital"></i>
            </div>
        </div>
        
        <div class="core1-stat-card">
            <div>
                <p class="text-sm text-gray mb-5">On Waiting List</p>
                <p class="core1-title text-purple">{{ $stats['on_waiting_list'] }}</p>
            </div>
            <div class="icon-box" style="background: #f3e8ff; color: #7e22ce;">
                <i class="bi bi-hourglass-split"></i>
            </div>
        </div>
    </div>

    <div class="dashboard-grid">
        <!-- Waiting List -->
        <div class="core1-card no-hover">
            <div class="core1-flex-between mb-20">
                <h3 class="m-0" style="text-align: left;">Waiting list</h3>
                <span class="core1-badge core1-badge-active">{{ count($waitingList) }} Pending</span>
            </div>
            <div class="core1-table-container shadow-none border-0">
                <table class="core1-table">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Preferred Date</th>
                            <th>Priority</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($waitingList as $entry)
                            <tr>
                                <td>
                                    <div class="text-sm font-medium">{{ $entry->patient->name }}</div>
                                    <div class="text-xs text-gray">{{ $entry->patient->patient_id }}</div>
                                </td>
                                <td>{{ $entry->preferred_date ? $entry->preferred_date->format('M d, Y') : 'Anytime' }}</td>
                                <td><span class="text-orange">Medium</span></td>
                                <td>
                                    <span class="core1-badge core1-badge-inactive">
                                        {{ ucfirst($entry->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state-cell p-40">
                                    <i class="bi bi-inbox text-gray mb-10" style="font-size: 2rem; display: block;"></i>
                                    No patients on the waiting list.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Activity Placeholder -->
        <div class="core1-card no-hover">
            <div class="core1-flex-between mb-20">
                <h3 class="m-0" style="text-align: left;">Room Status</h3>
                <a href="#" class="text-sm text-blue">View All Rooms</a>
            </div>
            <div class="room-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;">
                @for($i = 101; $i <= 116; $i++)
                    <div style="padding: 10px; border-radius: 8px; border: 1px solid #e5e7eb; text-align: center; background: {{ $i % 3 == 0 ? '#fee2e2' : '#f0fdf4' }}">
                        <div class="text-xs font-bold">{{ $i }}</div>
                        <i class="bi bi-safe2 {{ $i % 3 == 0 ? 'text-red' : 'text-green' }}"></i>
                    </div>
                @endfor
            </div>
            <div class="mt-20 d-flex gap-4">
                <div class="d-flex items-center gap-2 text-xs">
                    <span style="width: 10px; height: 10px; border-radius: 2px; background: #f0fdf4;"></span> Available
                </div>
                <div class="d-flex items-center gap-2 text-xs">
                    <span style="width: 10px; height: 10px; border-radius: 2px; background: #fee2e2;"></span> Occupied
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.ml-10 { margin-left: 10px; }
.text-blue { color: #2563eb; text-decoration: none; }
.text-blue:hover { text-decoration: underline; }
.room-grid i { font-size: 1.2rem; }
.icon-box {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}
</style>
@endsection
