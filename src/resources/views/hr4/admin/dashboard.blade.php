@extends('layouts.hr4.app')

@section('title', 'Admin Dashboard - HR4')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">HR4 Admin Dashboard</h2>
    
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $stats['total_employees'] }}</h4>
                            <p>Total Employees</p>
                        </div>
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $stats['active_employees'] }}</h4>
                            <p>Active Employees</p>
                        </div>
                        <i class="bi bi-person-check fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $stats['on_leave'] ?? 0 }}</h4>
                            <p>On Leave</p>
                        </div>
                        <i class="bi bi-calendar-x fs-1"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $stats['departments'] ?? 0 }}</h4>
                            <p>Departments</p>
                        </div>
                        <i class="bi bi-building fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Employees Overview</h5>
                    <canvas id="employeesChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Employees -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Recent Employees</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Status</th>
                                    <th>Hired At</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_employees as $emp)
                                <tr>
                                    <td>{{ $emp->full_name ?? $emp->first_name . ' ' . $emp->last_name }}</td>
                                    <td>{{ $emp->position ?? '-' }}</td>
                                    <td>{{ $emp->status ?? 'Active' }}</td>
                                    <td>{{ optional($emp->created_at)->format('Y-m-d') }}</td>
                                    <td><a href="{{ route('hr.hr4.admin.employees.show', $emp->id) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No recent employees found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.Chart && document.getElementById('employeesChart')) {
        const ctx = document.getElementById('employeesChart').getContext('2d');
        const data = {
            labels: ['Active', 'On Leave', 'Inactive'],
            datasets: [{
                data: [{{ $stats['active_employees'] ?? 0 }}, {{ $stats['on_leave'] ?? 0 }}, {{ max(0, ($stats['total_employees'] ?? 0) - ($stats['active_employees'] ?? 0) - ($stats['on_leave'] ?? 0)) }}],
                backgroundColor: ['#198754', '#ffc107', '#6c757d']
            }]
        };
        new Chart(ctx, { type: 'doughnut', data: data, options: { responsive: true } });
    }
});
</script>
@endpush