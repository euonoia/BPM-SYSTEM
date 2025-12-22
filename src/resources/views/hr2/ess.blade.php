@extends('layouts.app')

@section('content')
<h1>Employee Self Service (ESS)</h1>

@if(session('message'))
    <p style="color: green;">{{ session('message') }}</p>
@endif

<form method="POST" action="{{ route('hr2.ess.store') }}">
    @csrf
    <label>Type:</label>
    <select name="type" required>
        <option value="">Select Request Type</option>
        <option value="Leave">Leave</option>
        <option value="Overtime">Overtime</option>
        <option value="Payroll Issue">Payroll Issue</option>
        <option value="Other">Other</option>
    </select>
    <br><br>
    <label>Details:</label>
    <textarea name="details" placeholder="Request details..." required></textarea>
    <br><br>
    <button type="submit">Submit Request</button>
</form>

<br>

<table border="1" cellpadding="6">
    <thead>
        <tr>
            <th>ESS ID</th>
            <th>Type</th>
            <th>Details</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
    </thead>
    <tbody>
        @forelse($requests as $req)
        <tr>
            <td>{{ $req->ess_id }}</td>
            <td>{{ $req->type }}</td>
            <td>{{ $req->details }}</td>
            <td>{{ ucfirst($req->status) }}</td>
            <td>{{ $req->created_at }}</td>
            <td>{{ $req->updated_at }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align:center;">No ESS requests found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
