<div class="header">
    <h2>Welcome, {{ auth()->user()->name }}</h2>
    <p>Billing Dashboard</p>
</div>

<div class="grid">
    <div class="card">
        <h3>Today's Revenue</h3>
        <p>${{ number_format($stats['today_revenue'] ?? 0, 2) }}</p>
    </div>

    <div class="card">
        <h3>Monthly Revenue</h3>
        <p>${{ number_format($stats['monthly_revenue'] ?? 0, 2) }}</p>
    </div>

    <div class="card">
        <h3>Pending Bills</h3>
        <p>{{ $stats['pending_bills'] ?? 0 }}</p>
    </div>

    <div class="card">
        <h3>Overdue Bills</h3>
        <p>{{ $stats['overdue_bills'] ?? 0 }}</p>
    </div>

    <div class="card">
        <h3>Total Bills</h3>
        <p>{{ $stats['total_bills'] ?? 0 }}</p>
    </div>

    <div class="card">
        <h3>Paid Bills</h3>
        <p>{{ $stats['paid_bills'] ?? 0 }}</p>
    </div>
</div>

<div class="dashboard-grid">
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
                    <th>Patient</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingBills as $bill)
                <tr>
                    <td>{{ $bill->bill_number ?? 'N/A' }}</td>
                    <td>{{ $bill->patient->name ?? 'N/A' }}</td>
                    <td>${{ number_format($bill->total ?? 0, 2) }}</td>
                    <td><span class="status-{{ $bill->status }}">{{ ucfirst($bill->status) }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="empty-state-cell">No pending bills found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Overdue Bills -->
    <div class="card no-hover card-scrollable">
        <div class="header">
            <h2>Overdue Bills</h2>
            <p>Bills past due date</p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Bill Number</th>
                    <th>Patient</th>
                    <th>Due Date</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($overdueBills as $bill)
                <tr>
                    <td>{{ $bill->bill_number ?? 'N/A' }}</td>
                    <td>{{ $bill->patient->name ?? 'N/A' }}</td>
                    <td>{{ $bill->due_date ? \Carbon\Carbon::parse($bill->due_date)->format('M d, Y') : 'N/A' }}</td>
                    <td>${{ number_format($bill->total ?? 0, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="empty-state-cell">No overdue bills found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Recent Bills -->
    <div class="card no-hover card-scrollable">
        <div class="header">
            <h2>Recent Bills</h2>
            <p>Latest bill transactions</p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Bill Number</th>
                    <th>Patient</th>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBills as $bill)
                <tr>
                    <td>{{ $bill->bill_number ?? 'N/A' }}</td>
                    <td>{{ $bill->patient->name ?? 'N/A' }}</td>
                    <td>{{ $bill->bill_date ? \Carbon\Carbon::parse($bill->bill_date)->format('M d, Y') : 'N/A' }}</td>
                    <td>${{ number_format($bill->total ?? 0, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="empty-state-cell">No recent bills found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
