@extends('layouts.app')

@section('content')
<h1>Training Sessions</h1>
<table border="1">
    <thead>
        <tr>
            <th>Training Code</th>
            <th>Training Title</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($sessions as $session)
        <tr>
            <td>{{ $session->training_code }}</td>
            <td>{{ $session->training_title }}</td>
            <td>{{ $session->start_datetime->format('Y-m-d') }}</td>
            <td>{{ $session->end_datetime->format('Y-m-d') }}</td>
            <td>
                {{ $session->enrolls->first() ? $session->enrolls->first()->status : 'Not Enrolled' }}
            </td>
            <td>
                @if(!$session->enrolls->first())
                    <a href="{{ route('hr.training.enroll', $session->training_id) }}">Enroll</a>
                @else
                    Enrolled
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6">No training sessions available.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
