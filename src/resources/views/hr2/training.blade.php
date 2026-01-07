@extends('layouts.hr2.app')

@section('content')

<h1>Available Training Sessions</h1>

@if(session('message'))
    <p style="color: green;">{{ session('message') }}</p>
@endif

<table border="1" cellpadding="6">
    <thead>
        <tr>
            <th>Title</th>
            <th>Trainer</th>
            <th>Start</th>
            <th>End</th>
            <th>Location</th>
            <th>Capacity</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse($sessions as $session)
        @php
            $enrolled = $session->enrolls->isNotEmpty();
        @endphp
        <tr>
            <td>{{ $session->title }}</td>
            <td>{{ $session->trainer }}</td>
            <td>{{ $session->start_datetime->format('Y-m-d H:i') }}</td>
            <td>{{ $session->end_datetime->format('Y-m-d H:i') }}</td>
            <td>{{ $session->location }}</td>
            <td>{{ $session->capacity }}</td>

            <td>{{ $enrolled ? 'Enrolled' : 'Not Enrolled' }}</td>

            <td>
                @if(!$enrolled)
                    <form method="POST"
                          action="{{ route('hr2.training.enroll', $session->training_id) }}">
                        @csrf
                        <button type="submit">Enroll</button>
                    </form>
                @else
                    —
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" style="text-align:center;">No training sessions found.</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection
