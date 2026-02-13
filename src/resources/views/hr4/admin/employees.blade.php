@extends('layouts.hr4.app')

@section('title', 'Employees - HR4 Admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Employees</h2>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $e)
                        <tr>
                            <td>{{ $e->employee_id }}</td>
                            <td>{{ $e->first_name }} {{ $e->last_name }}</td>
                            <td>{{ $e->department }}</td>
                            <td>{{ $e->position }}</td>
                            <td>{{ ucfirst($e->status ?? $e->employment_type ?? 'active') }}</td>
                            <td>
                                <a href="{{ route('hr.hr4.admin.employees.show', $e->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No employees found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $employees->links() }}
        </div>
    </div>
</div>
@endsection
