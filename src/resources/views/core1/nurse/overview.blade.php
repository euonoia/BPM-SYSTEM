<div class="header">
    <h2>Welcome, {{ auth()->user()->name }}</h2>
    <p>Nurse Dashboard Overview</p>
</div>

<div class="grid">
    <div class="card">
        <h3>Today's Appointments</h3>
        <p>{{ $stats['today_appointments'] ?? 0 }}</p>
    </div>

    <div class="card">
        <h3>Active Patients</h3>
        <p>{{ $stats['active_patients'] ?? 0 }}</p>
    </div>

    <div class="card">
        <h3>New Patients Today</h3>
        <p>{{ $stats['today_registrations'] ?? 0 }}</p>
    </div>

    <div class="card">
        <h3>Records This Week</h3>
        <p>{{ $stats['recent_records'] ?? 0 }}</p>
    </div>
</div>

@if(isset($todayAppointments) && $todayAppointments->count() > 0)
<div style="margin-top: 30px;">
    <div class="header">
        <h2>Today's Appointments</h2>
        <p>Upcoming appointments scheduled for today</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Patient</th>
                <th>Time</th>
                <th>Doctor</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($todayAppointments as $appointment)
            <tr>
                <td>{{ $appointment->patient->name ?? 'N/A' }}</td>
                <td>{{ $appointment->appointment_time ? \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') : 'N/A' }}</td>
                <td>{{ $appointment->doctor->name ?? 'N/A' }}</td>
                <td><span class="status-{{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@if(isset($recentPatients) && $recentPatients->count() > 0)
<div style="margin-top: 30px;">
    <div class="header">
        <h2>Recent Patients</h2>
        <p>Recently registered patients</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Patient ID</th>
                <th>Gender</th>
                <th>Registered</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentPatients as $patient)
            <tr>
                <td>{{ $patient->name }}</td>
                <td>{{ $patient->patient_id }}</td>
                <td>{{ ucfirst($patient->gender) }}</td>
                <td>{{ $patient->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
