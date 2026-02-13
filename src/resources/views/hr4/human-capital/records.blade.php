@extends('layouts.hr4.app')
@section('title', 'Records - HR4')
@section('content')
<div class="container">
    <h2>Employee Records</h2>
    <p class="text-muted">Manage all employee information</p>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr><th>ID</th><th>Name</th><th>Department</th><th>Position</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse($employees as $emp)
                    <tr>
                        <td>{{ $emp->employee_id }}</td>
                        <td>{{ $emp->first_name }} {{ $emp->last_name }}</td>
                        <td>{{ $emp->department }}</td>
                        <td>{{ $emp->position }}</td>
                        <td>
                            @auth('admin')
                            <a href="{{ route('hr.hr4.admin.employees.show', $emp->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                            @else
                            <span class="text-muted">—</span>
                            @endauth
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No records yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $employees->links() }}
        </div>
    </div>
    <a href="{{ route('hr.hr4.human-capital.process') }}" class="btn btn-primary mt-3">Add Employee</a>
</div>
@endsection