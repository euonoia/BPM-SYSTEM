@extends('layouts.hr2.admin.app')

@section('title', 'Admin Dashboard')

@section('content')
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
@endsection
