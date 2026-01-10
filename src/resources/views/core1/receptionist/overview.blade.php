<div class="core1-header">
    <h2 class="core1-title">Receptionist Overview</h2>
    <p class="core1-subtitle">Manage appointments and patient registrations</p>
</div>

<div class="core1-stats-grid">
    <div class="core1-stat-card">
        <div class="d-flex flex-col items-center w-full">
            <h3 class="core1-info-item h3 text-center mb-10">Today's Appointments</h3>
            <p class="core1-title text-blue">{{ $stats['today_appointments'] ?? 0 }}</p>
        </div>
    </div>

    <div class="core1-stat-card">
        <div class="d-flex flex-col items-center w-full">
            <h3 class="core1-info-item h3 text-center mb-10">Today's Registrations</h3>
            <p class="core1-title text-green">{{ $stats['today_registrations'] ?? 0 }}</p>
        </div>
    </div>

    <div class="core1-stat-card">
        <div class="d-flex flex-col items-center w-full">
            <h3 class="core1-info-item h3 text-center mb-10">Total Patients</h3>
            <p class="core1-title text-purple">{{ $stats['total_patients'] ?? 0 }}</p>
        </div>
    </div>

    <div class="core1-stat-card">
        <div class="d-flex flex-col items-center w-full">
            <h3 class="core1-info-item h3 text-center mb-10">Pending Appointments</h3>
            <p class="core1-title text-orange">{{ $stats['pending_appointments'] ?? 0 }}</p>
        </div>
    </div>
</div>

<div class="core1-dashboard-split">
    <!-- Today's Appointments -->
    <div class="core1-card no-hover has-header overflow-hidden core1-scroll-card">
        <div class="core1-card-header">
            <h2 class="core1-title core1-section-title mb-0">Today's Appointments</h2>
        </div>
        <div class="core1-table-container shadow-none core1-scroll-area">
            <table class="core1-table">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Time</th>
                        <th>Type</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($todayAppointments as $appointment)
                    <tr>
                        <td>
                            <div class="font-bold text-blue">{{ $appointment->patient->name ?? 'N/A' }}</div>
                        </td>
                        <td>{{ $appointment->doctor->name ?? 'N/A' }}</td>
                        <td>{{ $appointment->appointment_time ? \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') : 'N/A' }}</td>
                        <td>{{ ucfirst($appointment->type ?? 'N/A') }}</td>
                        <td>
                            @php
                                $statusClass = 'tag-pending';
                                if($appointment->status == 'scheduled') $statusClass = 'core1-tag-recovering';
                                if($appointment->status == 'completed') $statusClass = 'core1-tag-stable';
                            @endphp
                            <span class="core1-status-tag {{ $statusClass }}">{{ ucfirst($appointment->status) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty-state-cell text-center p-40">No appointments scheduled for today.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Registrations -->
    <div class="core1-card no-hover has-header overflow-hidden core1-scroll-card">
        <div class="core1-card-header">
            <h2 class="core1-title core1-section-title mb-0">Recent Patient Registrations</h2>
        </div>
        <div class="core1-table-container shadow-none core1-scroll-area">
            <table class="core1-table">
                <thead>
                    <tr>
                        <th>Patient ID</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Registered At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentRegistrations as $patient)
                    <tr>
                        <td class="text-xs text-gray font-mono">{{ $patient->patient_id ?? $patient->id }}</td>
                        <td class="font-bold text-blue">{{ $patient->name }}</td>
                        <td>{{ ucfirst($patient->gender) }}</td>
                        <td>{{ $patient->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty-state-cell text-center p-40">No recent registrations found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
