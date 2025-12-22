@extends('layouts.app')

@section('content')
<h1>ESS Requests</h1>

<form action="{{ route('hr.ess.store') }}" method="POST">
    @csrf
    <label>Type:</label>
    <input type="text" name="type" required>
    <label>Details:</label>
    <textarea name="details" required></textarea>
    <button type="submit">Submit Request</button>
</form>

<table border="1">
    <thead>
        <tr>
            <th>ESS ID</th>
            <th>Type</th>
            <th>Details</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @forelse($requests as $req)
        <tr>
            <td>{{ $req->ess_id }}</td>
            <td>{{ $req->type }}</td>
            <td>{{ $req->details }}</td>
            <td>{{ $req->status }}</td>
            <td>{{ $req->created_at->format('Y-m-d') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5">No ESS requests found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
