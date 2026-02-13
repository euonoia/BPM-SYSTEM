@extends('layouts.hr4.app')
@section('title', 'Review - HR4')
@section('content')
<div class="container">
    <h2>Compensation Review & Approval</h2>
    <p>Pending approvals will appear here</p>
    <a href="{{ route('hr.hr4.compensation.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection