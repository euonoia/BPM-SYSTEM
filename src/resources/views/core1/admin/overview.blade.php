<div class="header">
    <h2>Welcome, {{ auth()->user()->name }}</h2>
    <p>Here's what's happening in your hospital today</p>
</div>

<div class="grid">
    <div class="card">
        <h3>Total Patients</h3>
        <p>{{ number_format($stats['total_patients'] ?? 0) }}</p>
    </div>

    <div class="card">
        <h3>Today's Appointments</h3>
        <p>{{ $stats['today_appointments'] ?? 0 }}</p>
    </div>

    <div class="card">
        <h3>Bed Occupancy</h3>
        <p>{{ $stats['bed_occupancy']['occupied'] ?? 0 }}/{{ $stats['bed_occupancy']['total'] ?? 0 }}</p>
    </div>

    <div class="card">
        <h3>Monthly Revenue</h3>
        <p>${{ number_format(($stats['monthly_revenue'] ?? 0) / 1000) }}K</p>
    </div>
</div>

@if(isset($recentActivities) && count($recentActivities) > 0)
<div style="margin-top: 30px;">
    <div class="header">
        <h2>Recent Activities</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>Action</th>
                <th>Patient</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentActivities as $activity)
            <tr>
                <td>{{ $activity['action'] ?? 'N/A' }}</td>
                <td>{{ $activity['patient'] ?? 'N/A' }}</td>
                <td>{{ $activity['time'] ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@if(isset($alerts) && count($alerts) > 0)
<div style="margin-top: 30px;">
    <div class="header">
        <h2>Alerts & Notifications</h2>
    </div>
    <div style="display: flex; flex-direction: column; gap: 10px;">
        @foreach($alerts as $alert)
        <div class="alert {{ 
            $alert['priority'] === 'high' ? 'alert-error' : 
            ($alert['priority'] === 'medium' ? 'alert-warning' : 'alert-info') 
        }}">
            {{ $alert['message'] ?? 'N/A' }}
        </div>
        @endforeach
    </div>
</div>
@endif
