@extends('layouts.hr2.app')

@section('content')
<h1>All Competencies</h1>

<table border="1" cellpadding="6">
    <thead>
        <tr>
            <th>Code</th>
            <th>Title</th>
            <th>Description</th>
            <th>Group</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @forelse($competencies as $comp)
        <tr>
            <td>{{ $comp->code }}</td>
            <td>{{ $comp->title }}</td>
            <td>{!! nl2br(e($comp->description)) !!}</td>
            <td>{{ $comp->competency_group }}</td>
            <td>{{ $comp->created_at->format('Y-m-d') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align:center;">No competencies found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
