<div class="header">
    <h2>Welcome, Dr. {{ auth()->user()->name }}</h2>
    <p>Your dashboard overview</p>
</div>

<div class="grid">
    <div class="card">
        <h3>Today's Appointments</h3>
        <p>{{ $stats['today_appointments'] ?? 0 }}</p>
    </div>

    <div class="card">
        <h3>Upcoming Appointments</h3>
        <p>{{ $stats['upcoming_appointments'] ?? 0 }}</p>
    </div>

    <div class="card">
        <h3>Total Patients</h3>
        <p>{{ $stats['total_patients'] ?? 0 }}</p>
    </div>

    <div class="card">
        <h3>Records This Week</h3>
        <p>{{ $stats['recent_records'] ?? 0 }}</p>
    </div>
</div>

<div class="dashboard-grid">
    <!-- Today's Appointments -->
    <div class="card no-hover card-scrollable">
        <div class="header">
            <h2>Today's Appointments</h2>
            <p>Your scheduled appointments for today</p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Time</th>
                    <th>Type</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($todayAppointments as $appointment)
                <tr>
                    <td>{{ $appointment->patient->name ?? 'N/A' }}</td>
                    <td>{{ $appointment->appointment_time ? \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') : 'N/A' }}</td>
                    <td>{{ ucfirst($appointment->type ?? 'N/A') }}</td>
                    <td><span class="status-{{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="empty-state-cell">No appointments scheduled for today.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Upcoming Appointments -->
    <div class="card no-hover card-scrollable">
        <div class="header">
            <h2>Upcoming Appointments</h2>
            <p>Your next scheduled appointments</p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($upcomingAppointments as $appointment)
                <tr>
                    <td>{{ $appointment->patient->name ?? 'N/A' }}</td>
                    <td>{{ $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') : 'N/A' }}</td>
                    <td>{{ $appointment->appointment_time ? \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') : 'N/A' }}</td>
                    <td><span class="status-{{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="empty-state-cell">No upcoming appointments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
