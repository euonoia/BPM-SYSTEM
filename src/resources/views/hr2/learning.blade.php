@extends('layouts.app')

@section('content')
<h1>Learning / Courses</h1>
<table border="1">
    <thead>
        <tr>
            <th>Course Code</th>
            <th>Course Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($courses as $course)
        <tr>
            <td>{{ $course->course_code }}</td>
            <td>{{ $course->course_name }}</td>
            <td>
                {{ $course->enrolls->first() ? $course->enrolls->first()->status : 'Not Enrolled' }}
            </td>
            <td>
                @if(!$course->enrolls->first())
                    <a href="{{ route('hr2.learning.enroll', $course->id) }}">Enroll</a>
                @else
                    Enrolled
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4">No courses available.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
