@extends('layouts.hr4.app')

@section('title', 'Admins - HR4')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Admins</h2>
        <a href="{{ route('hr.hr4.admin.admins.create') }}" class="btn btn-primary">Create Admin</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $a)
                        <tr>
                            <td>{{ $a->name }}</td>
                            <td>{{ $a->email }}</td>
                            <td>{{ optional($a->created_at)->format('Y-m-d') }}</td>
                            <td class="text-end">
                                <a href="{{ route('hr.hr4.admin.admins.edit', $a->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('hr.hr4.admin.admins.destroy', $a->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete admin?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $admins->links() }}
        </div>
    </div>
</div>
@endsection
