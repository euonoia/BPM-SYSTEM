@extends('layouts.hr2.admin.app')

@section('title', 'Training Management - HR2 Admin')

@section('content')
<div class="container">
    <h2>Training Management</h2>

    <!-- Add Training Form -->
    <form method="POST" action="{{ route('admin.training.store') }}">
        @csrf
        <h3>Add New Training</h3>
        <input type="text" name="title" placeholder="Training Title" required>
        <textarea name="description" placeholder="Training Description"></textarea>
        <label>Start Date & Time:</label>
        <input type="datetime-local" name="start_datetime" required>
        <label>End Date & Time:</label>
        <input type="datetime-local" name="end_datetime">
        <input type="text" name="location" placeholder="Location">
        <input type="text" name="trainer" placeholder="Trainer Name">
        <input type="number" name="capacity" placeholder="Capacity">
        <button type="submit">Add Training</button>
    </form>

    <!-- Training Sessions Table -->
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Trainer</th>
                <th>Start</th>
                <th>End</th>
                <th>Location</th>
                <th>Capacity</th>
                <th>Attendees</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sessions as $s)
                <tr>
                    <td>{{ $s->title }}</td>
                    <td>{{ $s->trainer }}</td>
                    <td>{{ $s->start_datetime }}</td>
                    <td>{{ $s->end_datetime }}</td>
                    <td>{{ $s->location }}</td>
                    <td>{{ $s->capacity }}</td>
                    <td>{{ $s->enrolls_count }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.training.destroy', $s->id) }}" onsubmit="return confirm('Archive this training session?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-del">Archive</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;">No training sessions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
