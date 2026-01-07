@extends('layouts.hr2.admin.app')

@section('title', 'Competency Management')

@section('content')
<h2>Competency Management</h2>

<!-- Add Competency Form -->
<form method="POST" action="{{ route('admin.competency.store') }}">
    @csrf
    <h3>Add New Competency</h3> 
    <input type="text" name="title" placeholder="Title" required>
    <textarea name="description" placeholder="Description (optional)"></textarea>
    <input type="text" name="competency_group" placeholder="Group (e.g. Technical, Leadership)">
    <button type="submit">Add Competency</button>
</form>

<!-- Success Message -->
@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif

<!-- Competency Table -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Title</th>
            <th>Group</th>
            <th>Created</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($competencies as $c)
            <tr>
                <td>{{ $c->id }}</td>
                <td>{{ $c->code }}</td>
                <td>{{ $c->title }}</td>
                <td>{{ $c->competency_group }}</td>
                <td>{{ $c->created_at }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.competency.destroy', $c->id) }}" onsubmit="return confirm('Archive this competency?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color:red; background:none; border:none; cursor:pointer;">Archive</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" style="text-align:center;">No competencies found.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
