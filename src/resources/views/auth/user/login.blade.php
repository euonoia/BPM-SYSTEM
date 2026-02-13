@extends('layouts.auth')

@section('title', 'User Login - HR4')

@section('content')
<div class="card">
    <div class="card-body">
        <h3 class="login-title">
            <i class="bi bi-person-circle"></i> Employee Login
        </h3>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error:</strong> {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('user.login.post') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="employee@example.com" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <hr>
        <p style="text-align:center; color:#666; font-size:14px;">
            Are you an admin? <a href="{{ route('admin.login') }}">Admin Login</a>
        </p>
    </div>
</div>
@endsection
