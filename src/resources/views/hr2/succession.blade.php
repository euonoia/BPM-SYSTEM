@extends('layouts.hr2.app')

@section('content')

<div class="header">
    <h2>My Succession Plan</h2>
    <p>View positions you are assigned to and their readiness details.</p>
</div>

<table border="1" cellpadding="6">
    <thead>
        <tr>
            <th>Position</th>
            <th>Branch</th>
            <th>Criticality</th>
            <th>Readiness</th>
            <th>Effective At</th>
            <th>Development Plan</th>
        </tr>
    </thead>

    <tbody>
        @forelse($positions as $item)
            <tr>
                <td>{{ $item->position->position_title ?? '-' }}</td>
                <td>{{ $item->position->branch_id ?? '-' }}</td>
                <td>{{ ucfirst($item->position->criticality ?? '-') }}</td>
                <td>{{ ucfirst($item->readiness) }}</td>
                <td>{{ $item->effective_at }}</td>
                <td>{{ $item->development_plan }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align:center;">
                    You are not assigned to any succession positions.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
