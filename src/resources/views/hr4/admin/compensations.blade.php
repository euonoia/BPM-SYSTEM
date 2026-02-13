@extends('layouts.hr4.app')

@section('title', 'Compensations - HR4 Admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Compensation Adjustments</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Current → Proposed</th>
                            <th>Total Increase</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($compensations as $c)
                        <tr>
                            <td>
                                @if($c->employee)
                                    {{ $c->employee->first_name }} {{ $c->employee->last_name }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>₱{{ number_format($c->current_salary ?? 0, 0) }} → ₱{{ number_format($c->proposed_salary ?? 0, 0) }}</td>
                            <td>₱{{ number_format($c->total_increase ?? 0, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $c->status === 'pending' ? 'warning' : ($c->status === 'approved' ? 'success' : 'secondary') }}">
                                    {{ ucfirst($c->status) }}
                                </span>
                            </td>
                            <td>
                                @if($c->status === 'pending')
                                <form action="{{ route('hr.hr4.admin.compensations.approve', $c->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                </form>
                                <form action="{{ route('hr.hr4.admin.compensations.reject', $c->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No compensation adjustments found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $compensations->links() }}
        </div>
    </div>
</div>
@endsection
