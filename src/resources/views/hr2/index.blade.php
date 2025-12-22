@extends('layouts.app')

@section('content')
<div class="dashboard">
    <h2>Welcome, {{ $employee->first_name }}</h2>
    <p>Here’s your HR2 summary overview:</p>

    <div class="grid">
        @foreach($counts as $label => $count)
            <div class="card">
                <h3>{{ $label }}</h3>
                <p>{{ $count }}</p>
            </div>
        @endforeach
    </div>
</div>
@endsection
