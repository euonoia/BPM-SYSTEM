@extends('layouts.hr2.app')

@section('content')

<h1>Learning / Courses</h1>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="6">
    <thead>
        <tr>
            <th>Course ID</th>
            <th>Title</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse($courses as $course)
            @if($course->course_id)
            <tr>
                <td>{{ $course->course_id }}</td>
                <td>{{ $course->title }}</td>

                <td>
                    {{ $course->enrolls->isNotEmpty() ? 'Enrolled' : 'Not Enrolled' }}
                </td>

                <td>
                    @if($course->enrolls->isEmpty())
                        <form method="POST"
                              action="{{ route('hr2.learning.enroll', $course->course_id) }}">
                            @csrf
                            <button type="submit">Enroll</button>
                        </form>
                    @else
                        Enrolled
                    @endif
                </td>
            </tr>
            @endif
        @empty
        <tr>
            <td colspan="4">No courses available.</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection
