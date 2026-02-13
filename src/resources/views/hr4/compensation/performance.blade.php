@extends('layouts.hr4.app')
@section('title', 'Performance - HR4')
@section('content')
<div class="container">
    <h2>Performance Based Compensation</h2>
    <p>Process performance evaluations</p>
    <a href="{{ route('hr.hr4.compensation.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection