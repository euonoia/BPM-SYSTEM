<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR2 Module</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="{{ route('hr2.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('hr2.competencies') }}">Competencies</a></li>
                <li><a href="{{ route('hr2.learning') }}">Learning</a></li>
                <li><a href="{{ route('hr2.training') }}">Training</a></li>
                <li><a href="{{ route('hr2.ess') }}">ESS</a></li>
            </ul>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>
