<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR2 Module</title>

    <link rel="stylesheet" href="{{ asset('css/hr2/example.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<!-- Mobile Topbar -->
<div class="topbar">
    <button class="menu-toggle"
        onclick="document.querySelector('.sidebar').classList.toggle('show')">
        ☰
    </button>
    <div class="title">HR2</div>
</div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="HR2 Logo">
        <div class="logo-text">HR2</div>
    </div>

    <nav>
        <a href="{{ route('hr2.dashboard') }}" class="{{ request()->routeIs('hr2.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('hr2.competencies') }}">
            <i class="bi bi-lightbulb"></i>
            <span>Competencies</span>
        </a>

        <a href="{{ route('hr2.learning') }}">
            <i class="bi bi-book"></i>
            <span>Learning</span>
        </a>

        <a href="{{ route('hr2.training') }}">
            <i class="bi bi-mortarboard"></i>
            <span>Training</span>
        </a>
        
        <a href="{{ route('hr2.succession') }}"
            class="{{ request()->routeIs('hr2.succession') ? 'active' : '' }}">
                <i class="bi bi-tree"></i>
                <span>Succession</span>
        </a>

        <a href="{{ route('hr2.ess') }}">
            <i class="bi bi-pencil-square"></i>
            <span>ESS</span>
        </a>

       <form id="logout-form" method="POST" action="{{ route('portal.logout') }}" style="display:none;">
            @csrf
        </form>

        <a href="#"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </a>

    </nav>
</div>

<!-- Main Content -->
<div class="main">
    <div class="main-inner">
        @yield('content')
    </div>
</div>

<script>
const sidebar = document.getElementById('sidebar');

// default collapsed on desktop
if (window.innerWidth > 768) {
    sidebar.classList.add('collapsed');
}

// hover expand (desktop)
sidebar.addEventListener('mouseenter', () => {
    if (window.innerWidth > 768) sidebar.classList.remove('collapsed');
});

sidebar.addEventListener('mouseleave', () => {
    if (window.innerWidth > 768) sidebar.classList.add('collapsed');
});

// close sidebar on mobile click outside
document.addEventListener('click', (e) => {
    const toggle = document.querySelector('.menu-toggle');
    if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
        sidebar.classList.remove('show');
    }
});
</script>

</body>
</html>
