@extends('layouts.app') 

@section('content')
<div class="navbar">
    <div><strong>HR2 Admin</strong></div>
    <div>
        <a href="{{ route('hr.hr2.admin.dashboard') }}">Dashboard</a>
        <a href="#">Add Admin</a>
        <a href="#">Competency</a>
        <a href="#">Learning</a>
        <a href="#">Training</a>
        <a href="#">Succession</a>
        <a href="#">ESS</a>
        <form method="POST" action="{{ route('hr.hr2.admin.logout') }}" style="display:inline;">
            @csrf
            <button type="submit" style="background:none;border:none;color:#fff;cursor:pointer;">Logout</button>
        </form>
    </div>
</div>

<div class="container">
    <div class="header">
        <h2>Welcome, {{ $admin->full_name }}</h2>
        <p>Here’s a quick overview of the HR2 system modules:</p>
    </div>

    <div class="grid">
        @foreach($counts as $label => $count)
            <div class="card">
                <h3>{{ $label }}</h3>
                <p>{{ $count }}</p>
            </div>
        @endforeach
    </div>
</div>

<footer>
    &copy; {{ date('Y') }} Microfinancial Management System — HR2 Module
</footer>
@endsection
