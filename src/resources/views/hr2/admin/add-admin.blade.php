@extends('layouts.hr2.admin.app')

@section('title', 'Add Admin')

@section('content')
<div class="header">
    <h2>Add New Admin</h2>
</div>

@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif

@if($errors->any())
    <div style="color:red;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.add.store') }}" method="POST">
    @csrf
    <div>
        <label>First Name</label>
        <input type="text" name="first_name" value="{{ old('first_name') }}" required>
    </div>
    <div>
        <label>Last Name</label>
        <input type="text" name="last_name" value="{{ old('last_name') }}" required>
    </div>
    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
    </div>
    <div>
        <label>Password</label>
        <input type="password" name="password" required>
    </div>
    <div>
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" required>
    </div>
    <div style="margin-top:15px;">
        <button type="submit">Add Admin</button>
    </div>
</form>
@endsection
