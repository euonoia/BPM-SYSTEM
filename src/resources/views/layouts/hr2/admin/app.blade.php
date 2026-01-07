<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'HR2 Admin Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body { font-family: Arial, sans-serif; background: #f3f4f6; margin: 0; }
        .navbar { background: #1f2937; color: #fff; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; }
        .navbar a { color: #fff; text-decoration: none; margin-left: 15px; font-size: 14px; }
        .navbar a:hover { text-decoration: underline; }
        .container { max-width: 1000px; margin: 40px auto; background: #fff; border-radius: 10px; padding: 25px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        .header h2 { margin: 0; color: #111827; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 20px; }
        .card { background: #f9fafb; border-radius: 10px; padding: 20px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: 0.2s ease; }
        .card:hover { transform: translateY(-3px); box-shadow: 0 3px 6px rgba(0,0,0,0.15); }
        .card h3 { color: #111827; margin-bottom: 8px; }
        .card p { font-size: 22px; font-weight: bold; color: #2563eb; }
        footer { text-align: center; padding: 10px; font-size: 13px; color: #555; margin-top: 40px; }
    </style>
</head>
<body>
    <div class="navbar">
        <div><strong>HR2 Admin</strong></div>
        <div>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.add') }}">Add Admin</a>
            <a href="{{ route('admin.competency') }}">Competency</a>
            <a href="{{ route('admin.learning') }}">Learning</a>
            <a href="{{ route('admin.training') }}">Training</a>
            <a href="{{ route('admin.succession') }}">Succession</a>
            <a href="{{ route('admin.ess') }}">ESS</a>

            <!-- Logout Form -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
        </div>
    </div>

    <div class="container">
        @yield('content')
    </div>

    <footer>
        &copy; {{ date('Y') }} Microfinancial Management System — HR2 Module
    </footer>
</body>
</html>
