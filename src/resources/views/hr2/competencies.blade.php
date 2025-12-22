@extends('layouts.app')

@section('content')
<h1>Competencies</h1>
<table border="1">
    <thead>
        <tr>
            <th>Competency Code</th>
            <th>Competency Name</th>
            <th>Description</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @forelse($competencies as $comp)
        <tr>
            <td>{{ $comp->competency_code }}</td>
            <td>{{ $comp->competency_name }}</td>
            <td>{{ $comp->description }}</td>
            <td>{{ $comp->created_at->format('Y-m-d') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4">No competencies found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
