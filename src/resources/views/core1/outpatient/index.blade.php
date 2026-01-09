@extends('core1.layouts.app')

@section('title', 'Outpatient Management')

@section('content')
<div class="core1-container">
    <div class="core1-flex-between core1-header">
        <div>
            <h1 class="core1-title">Outpatient Management</h1>
            <p class="core1-subtitle">Manage today's appointments and outpatient consultations</p>
        </div>
        <div class="d-flex gap-2">
            <button class="core1-btn core1-btn-outline">
                <i class="bi bi-calendar-event"></i>
                <span class="ml-10">Schedule</span>
            </button>
            <button class="core1-btn core1-btn-primary">
                <i class="bi bi-plus"></i>
                <span class="ml-10">New Registration</span>
            </button>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="core1-stats-grid">
        <div class="core1-stat-card">
            <div class="d-flex flex-col">
                <i class="bi bi-people text-blue mb-10" style="font-size: 24px;"></i>
                <p class="core1-title">{{ $stats['today_appointments'] }}</p>
                <p class="text-xs text-gray">Today's Appointments</p>
            </div>
        </div>
        
        <div class="core1-stat-card">
            <div class="d-flex flex-col">
                <i class="bi bi-check-circle text-green mb-10" style="font-size: 24px;"></i>
                <p class="core1-title">{{ $stats['completed'] }}</p>
                <p class="text-xs text-gray">Consultations Finished</p>
            </div>
        </div>
        
        <div class="core1-stat-card">
            <div class="d-flex flex-col">
                <i class="bi bi-hourglass-split text-orange mb-10" style="font-size: 24px;"></i>
                <p class="core1-title">{{ $stats['waiting'] }}</p>
                <p class="text-xs text-gray">Patients Waiting</p>
            </div>
        </div>

        <div class="core1-stat-card">
            <div class="d-flex flex-col">
                <i class="bi bi-clock-history text-blue mb-10" style="font-size: 24px;"></i>
                <p class="core1-title">{{ $stats['avg_wait_time'] }}</p>
                <p class="text-xs text-gray">Avg. Wait Time</p>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="core1-card no-hover p-20 mt-30">
        <div class="d-flex justify-between items-center">
            <div class="d-flex gap-2 items-center" style="width: 100%;">
                <div style="position: relative; flex-grow: 1; max-width: 400px;">
                    <i class="bi bi-search" style="position: absolute; left: 12px; top: 10px; color: #9ca3af;"></i>
                    <input type="text" placeholder="Search by name, ID or specialist..." 
                        style="width: 100%; padding: 8px 12px 8px 35px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); font-size: 14px;">
                </div>
                <select style="padding: 8px 12px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); font-size: 14px; background: white;">
                    <option>All Departments</option>
                    <option>Cardiology</option>
                    <option>Dermatology</option>
                    <option>General Medicine</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Appointments Table -->
    <div class="core1-card no-hover p-0 overflow-hidden mt-20">
        <div class="p-20 border-bottom">
            <h3 class="core1-title" style="font-size: 18px;">Today's Schedule</h3>
        </div>
        <div class="core1-table-container shadow-none">
            <table class="core1-table">
                <thead>
                    <tr>
                        <th>TIME</th>
                        <th>PATIENT INFO</th>
                        <th>DOCTOR / DEPT</th>
                        <th>TYPE</th>
                        <th>STATUS</th>
                        <th class="text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $apt)
                        <tr>
                            <td class="font-bold">{{ $apt['time'] }}</td>
                            <td>
                                <div class="font-bold text-blue">{{ $apt['patient'] }}</div>
                                <div class="text-xs text-gray">{{ $apt['id'] }}</div>
                            </td>
                            <td>
                                <div class="font-medium">{{ $apt['doctor'] }}</div>
                                <div class="text-xs text-gray">{{ $apt['department'] }}</div>
                            </td>
                            <td>
                                <span class="core1-status-tag" style="background: #f3f4f6; color: #374151;">
                                    {{ ucfirst($apt['type']) }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusClass = 'tag-pending';
                                    if(in_array($apt['status'], ['Arrived', 'Scheduled'])) $statusClass = 'core1-tag-recovering';
                                    if($apt['status'] == 'In Consultation') $statusClass = 'core1-tag-critical';
                                    if($apt['status'] == 'Waiting') $statusClass = 'core1-tag-cleaning';
                                @endphp
                                <span class="core1-status-tag {{ $statusClass }}">
                                    {{ $apt['status'] }}
                                </span>
                            </td>
                            <td class="text-right">
                                <div class="d-flex justify-end gap-2">
                                    <button class="core1-btn-sm core1-btn-outline" title="Check-in"><i class="bi bi-box-arrow-in-right"></i></button>
                                    <button class="core1-btn-sm core1-btn-outline" title="View History"><i class="bi bi-clock-history"></i></button>
                                    <button class="core1-btn-sm core1-btn-primary" title="Start Consultation"><i class="bi bi-play-fill"></i></button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
