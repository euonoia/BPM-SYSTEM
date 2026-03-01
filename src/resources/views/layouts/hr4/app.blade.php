<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HR4 - Hospital Management')</title>
    <link rel="stylesheet" href="{{ asset('css/hr4/professional.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    @yield('styles')
</head>
<body>

<div class="topbar">
    <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
</div>

<div class="sidebar" id="sidebar">
    <div class="logo">
        <img src="{{ asset('logo/deamns.png') }}" alt="HR4 Logo">
    </div>
    
    @if(auth()->guard('admin')->check())
    <nav>
        <!-- Admin Dashboard -->
        <a href="{{ route('hr.hr4.admin.index') }}" class="{{ request()->routeIs('hr.hr4.admin.index') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i> <span>Dashboard</span>
        </a>
        
        <!-- Employees Management -->
        <a href="{{ route('hr.hr4.admin.employees') }}" class="{{ request()->routeIs('hr.hr4.admin.employees*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> <span>Employees</span>
        </a>
        
        <!-- Manage HR Users -->
        <a href="{{ route('hr.hr4.admin.users.index') }}" class="{{ request()->routeIs('hr.hr4.admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> <span>Manage HR Users</span>
        </a>
        
        <!-- Payroll -->
        <a href="{{ route('hr.hr4.admin.payrolls') }}" class="{{ request()->routeIs('hr.hr4.admin.payrolls*') ? 'active' : '' }}">
            <i class="bi bi-cash-coin"></i> <span>Payroll</span>
        </a>
        
        <!-- Compensation -->
        <a href="{{ route('hr.hr4.admin.compensations') }}" class="{{ request()->routeIs('hr.hr4.admin.compensations*') ? 'active' : '' }}">
            <i class="bi bi-graph-up"></i> <span>Compensation</span>
        </a>
        
        <!-- Admin Management -->
        <a href="{{ route('hr.hr4.admin.admins.index') }}" class="{{ request()->routeIs('hr.hr4.admin.admins*') ? 'active' : '' }}">
            <i class="bi bi-shield-lock"></i> <span>Manage Admins</span>
        </a>
        
        <hr style="border-color: rgba(255,255,255,0.2);">
        
        <!-- Logout -->
        <form action="{{ route('admin.logout') }}" method="POST" class="sidebar-logout">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
            </button>
        </form>
    </nav>
    @elseif(auth()->guard('user')->check())
    <nav>
        <!-- Dashboard -->
        <a href="{{ route('hr.hr4.index') }}" class="{{ request()->routeIs('hr.hr4.index') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i> <span>Dashboard</span>
        </a>
        @php
            $u = auth()->guard('user')->user();
            $role = $u ? $u->role : '';
        @endphp

        <!-- Payroll (hr_head only) -->
        @if($role === 'hr_head')
            <a href="{{ route('hr.hr4.payroll.index') }}" class="{{ request()->routeIs('hr.hr4.payroll.*') ? 'active' : '' }}">
                <i class="bi bi-cash-coin"></i> <span>Payroll</span>
            </a>
        @endif

        <!-- Compensation (hr_head only) -->
        @if($role === 'hr_head')
            <a href="{{ route('hr.hr4.compensation.index') }}" class="{{ request()->routeIs('hr.hr4.compensation.*') ? 'active' : '' }}">
                <i class="bi bi-graph-up"></i> <span>Compensation</span>
            </a>
        @endif
        
        <hr style="border-color: rgba(255,255,255,0.2);">
        
        <!-- Logout -->
        <form action="{{ route('user.logout') }}" method="POST" class="sidebar-logout">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
            </button>
        </form>
    </nav>
    @else
    <nav style="text-align:center; padding:20px 0;">
        <p style="color:#ccc; margin-bottom:20px;">Not logged in</p>
        <a href="{{ route('admin.login') }}" class="btn btn-sm btn-primary mb-2" style="width:100%; display:block;">
            <i class="bi bi-shield-lock"></i> Admin Login
        </a>
        <a href="{{ route('user.login') }}" class="btn btn-sm btn-outline-light" style="width:100%; display:block;">
            <i class="bi bi-person"></i> User Login
        </a>
    </nav>
    @endif
</div>

<div class="main">
    <div class="main-inner">
        @yield('content')
    </div>
</div>

<script>
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('show');
}

document.addEventListener('click', (e) => {
    const sidebar = document.querySelector('.sidebar');
    const toggle = document.querySelector('.menu-toggle');
    if (window.innerWidth <= 768 && !sidebar.contains(e.target) && !toggle.contains(e.target)) {
        sidebar.classList.remove('show');
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@yield('scripts')

</body>
</html>