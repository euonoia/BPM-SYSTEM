@extends('layouts.hr4.app')
@section('title', 'Job Grading - HR4')
@section('content')
<div class="container">
    <h2>Job Grading & Salary Structure</h2>
    <p>Define and manage job levels</p>
    <a href="{{ route('hr.hr4.compensation.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection