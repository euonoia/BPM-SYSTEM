<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <!-- Link external CSS -->
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>
    <h1>Welcome to the Landing Page</h1>

    <h2>Landing Page</h2>
    <ul>
        <li>
            <a href="{{ route('landing.landingPage.index') }}" class="text-blue-600 hover:underline">
                Landing Page
            </a>
        </li>
    </ul>

    <h2>Authentication</h2>
    <ul>
        <li><a href="{{ route('login') }}">Login</a></li>
        <li><a href="{{ route('register') }}">Register</a></li>
    </ul>
    
    <h2>Core Modules</h2>
    <ul>
        <li><a href="{{ route('core1Controller@index') }}">Go to Core1 Index</a></li>
        <li><a href="{{ route('core.core2.index') }}">Go to Core2 Index</a></li>
    </ul>

    <h2>Logistics Modules</h2>
    <ul>
        <li><a href="{{ route('logistics.logistics1.index') }}">Go to Logistics1 Index</a></li>
        <li><a href="{{ route('logistics.logistics2.index') }}">Go to Logistics2 Index</a></li>
    </ul>

   <h2>HR Modules</h2>
<ul>
    <li>
        <a href="{{ route('hr.hr1.index') }}">Go to HR1 Index</a>
    </li>

    <li>
        <a href="{{ route('hr.hr3.index') }}">Go to HR3 Index</a>
    </li>

    <li>
        <a href="{{ route('hr.hr4.index') }}">Go to HR4 Index</a>
    </li>
</ul>


    <h2>Financial Module</h2>
    <ul>
        <li><a href="{{ route('financials.index') }}">Go to Financials Index</a></li>
    </ul>

    <h2>Other Modules</h2>
    <ul>
        <li><a href="{{ route('patients.index') }}">Go to Patients</a></li>
        <li><a href="{{ url('/') }}">Back to Home</a></li>
    </ul>
</body>
</html>
