@if(isset($patient))
<div class="header">
    <h2>Welcome, {{ auth()->user()->name }}</h2>
    <p>Your patient portal</p>
</div>

<div class="grid">
    <div class="card">
        <h3>Upcoming Appointments</h3>
        <p>{{ $stats['upcoming_appointments'] ?? 0 }}</p>
    </div>

    <div class="card">
        <h3>Total Appointments</h3>
        <p>{{ $stats['total_appointments'] ?? 0 }}</p>
    </div>

    <div class="card">
        <h3>Medical Records</h3>
        <p>{{ $stats['medical_records'] ?? 0 }}</p>
    </div>

    <div class="card">
        <h3>Pending Bills</h3>
        <p>{{ $stats['pending_bills'] ?? 0 }}</p>
    </div>
</div>

<div class="dashboard-grid">
    <!-- Upcoming Appointments -->
    <div class="card no-hover card-scrollable">
        <div class="header">
            <h2>Upcoming Appointments</h2>
            <p>Your scheduled appointments</p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($upcomingAppointments as $appointment)
                <tr>
                    <td>{{ $appointment->doctor->name ?? 'N/A' }}</td>
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

    <!-- Pending Bills -->
    <div class="card no-hover card-scrollable">
        <div class="header">
            <h2>Pending Bills</h2>
            <p>Bills awaiting payment</p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Bill Number</th>
                    <th>Date</th>
                    <th>Due Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingBills as $bill)
                <tr>
                    <td>{{ $bill->bill_number ?? 'N/A' }}</td>
                    <td>{{ $bill->bill_date ? \Carbon\Carbon::parse($bill->bill_date)->format('M d, Y') : 'N/A' }}</td>
                    <td>{{ $bill->due_date ? \Carbon\Carbon::parse($bill->due_date)->format('M d, Y') : 'N/A' }}</td>
                    <td>${{ number_format($bill->total ?? 0, 2) }}</td>
                    <td><span class="status-{{ $bill->status }}">{{ ucfirst($bill->status) }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="empty-state-cell">No pending bills found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@else
<div class="header">
    <h2>Patient Profile Not Found</h2>
    <p>Your account is not linked to a patient profile. Please contact the receptionist to register as a patient.</p>
</div>
@endif
