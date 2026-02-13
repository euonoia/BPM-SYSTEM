@extends('layouts.hr4.app')
@section('title', 'Recruitment - HR4')
@section('content')
<div class="container">
    <h2>Recruitment & Onboarding</h2>
    <p>Hire new employees</p>
    <div class="row">
        <div class="col-md-4"><div class="card text-center"><div class="card-body"><h3>0</h3><p>Applicants</p></div></div></div>
        <div class="col-md-4"><div class="card text-center"><div class="card-body"><h3>0</h3><p>Interviews</p></div></div></div>
        <div class="col-md-4"><div class="card text-center"><div class="card-body"><h3>0</h3><p>Ready to Hire</p></div></div></div>
    </div>
    <a href="{{ route('hr.hr4.human-capital.process') }}" class="btn btn-success mt-3">Process New Hire</a>
</div>
@endsection