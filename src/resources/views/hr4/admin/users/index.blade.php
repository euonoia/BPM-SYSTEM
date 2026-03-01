@extends('layouts.hr4.app')

@section('title', 'Manage Users - HR4 Admin')

@section('content')
<div class="container-fluid">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h2 style="margin: 0 0 10px 0;">Manage HR Users</h2>
            <p class="text-muted" style="margin: 0;">Create and manage HR staff and HR head accounts</p>
        </div>
        <a href="{{ route('hr.hr4.admin.users.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add New User
        </a>
    </div>

    @if($users->count() > 0)
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                        <tr>
                            <td><span class="badge bg-info">{{ $u->employee_id }}</span></td>
                            <td>
                                <strong>{{ $u->first_name }} {{ $u->last_name }}</strong>
                            </td>
                            <td>
                                @if($u->role === 'hr_head')
                                    <span class="badge bg-danger">HR Head</span>
                                @elseif($u->role === 'hr_staff')
                                    <span class="badge bg-info">HR Staff</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($u->role) }}</span>
                                @endif
                            </td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->department ?? 'N/A' }}</td>
                            <td>{{ $u->position ?? 'N/A' }}</td>
                            <td>
                                @if($u->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-warning">{{ ucfirst($u->status) }}</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ route('hr.hr4.admin.users.edit', $u->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('hr.hr4.admin.users.destroy', $u->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($users instanceof \Illuminate\Pagination\Paginator)
            <div style="margin-top: 20px;">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>
    @else
    <div class="card">
        <div class="card-body text-center" style="padding: 60px 20px;">
            <i class="bi bi-inbox" style="font-size: 48px; color: #ddd; display: block; margin-bottom: 20px;"></i>
            <h5 style="color: #999; margin-bottom: 15px;">No HR Users Found</h5>
            <p class="text-muted" style="margin-bottom: 20px;">Get started by creating your first HR user account.</p>
            <a href="{{ route('hr.hr4.admin.users.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Create First User
            </a>
        </div>
    </div>
    @endif
