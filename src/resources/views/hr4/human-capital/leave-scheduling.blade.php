@extends('layouts.hr4.app')
@section('title', 'Leave - HR4')
@section('content')
<div class="container">
    <h2>Leave & Shift Scheduling</h2>
    <p>Manage schedules</p>
    <div class="row">
        <div class="col-md-3"><div class="card bg-info text-white text-center"><div class="card-body"><h3>0</h3><p>On Leave</p></div></div></div>
        <div class="col-md-3"><div class="card bg-warning text-center"><div class="card-body"><h3>0</h3><p>Pending</p></div></div></div>
        <div class="col-md-3"><div class="card bg-success text-white text-center"><div class="card-body"><h3>0</h3><p>Present</p></div></div></div>
        <div class="col-md-3"><div class="card bg-danger text-white text-center"><div class="card-body"><h3>0</h3><p>Absent</p></div></div></div>
    </div>
</div>
@endsection