<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital System Portal - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="portal-container">
        <!-- Image / Hero Side -->
        <div class="hero-side">
            <div class="hero-content">
                <h1 class="hero-title">Your Health,<br>Our Priority</h1>
                <p class="hero-subtitle">
                    Providing compassionate care with advanced medical expertise and state-of-the-art facilities
                </p>
            </div>
        </div>

        <!-- Login Side -->
        <div class="login-side">
            <h2 class="hospital-title">Hospital System</h2>
            
            <div class="login-card">
                <h3 class="portal-heading">Patient Portal</h3>

                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="alert-error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Login Form -->
                <form action="{{ route('core.login.submit') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            placeholder="Enter email" 
                            required 
                            value="{{ old('email') }}"
                            autofocus
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Enter password" 
                            required
                        >
                    </div>
                    
                    <button type="submit" class="login-btn">Login</button>
                </form>

                <!-- Footer -->
                <div class="login-footer">
                    Don't have an account? 
                    <a href="{{ route('core.register') }}" class="login-link">Register</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
