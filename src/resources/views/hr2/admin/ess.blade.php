@extends('layouts.hr2.admin.app')

@section('title', 'ESS Requests - HR2 Admin')

@section('content')
<div class="container">
    <h2>Employee Self-Service Requests</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Employee</th>
                <th>Type</th>
                <th>Payload</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $r)
                @php
                    $statusClass = match($r->status) {
                        'approved' => 'status-approved',
                        'rejected' => 'status-rejected',
                        'closed' => 'status-closed',
                        default => 'status-pending',
                    };
                    $disableApproveReject = in_array($r->status, ['approved','rejected','closed']);
                    $disableClose = $r->status == 'closed';
                @endphp
                <tr>
                    <td>{{ $r->id }}</td>
                    <td>{{ $r->employee->first_name }} {{ $r->employee->last_name }}</td>
                    <td>{{ ucfirst($r->type) }}</td>
                    <td>{{ $r->details }}</td>
                    <td><strong class="{{ $statusClass }}">{{ ucfirst($r->status) }}</strong></td>
                    <td>{{ $r->created_at }}</td>
                    <td>{{ $r->updated_at }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.ess.updateStatus', $r->id) }}">
                            @csrf
                            <button type="submit" name="status" value="approved" class="approve" {{ $disableApproveReject ? 'disabled' : '' }}>Approve</button>
                            <button type="submit" name="status" value="rejected" class="reject" {{ $disableApproveReject ? 'disabled' : '' }}>Reject</button>
                            <button type="submit" name="status" value="closed" class="close" {{ $disableClose ? 'disabled' : '' }}>Close</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" style="text-align:center;">No requests found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
