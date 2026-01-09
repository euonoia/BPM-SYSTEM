@php
    $user = auth()->user();
    $currentRoute = request()->route()->getName();
    
    $navItems = [
        ['id' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'bi-house-door', 'roles' => ['admin', 'doctor', 'nurse', 'patient', 'receptionist', 'billing'], 'route' => $user->role . '.dashboard'],
        ['id' => 'patients', 'label' => 'Patient Management', 'icon' => 'bi-people', 'roles' => ['admin', 'doctor', 'nurse', 'receptionist'], 'route' => 'patients.index'],
        ['id' => 'appointments', 'label' => 'Appointments', 'icon' => 'bi-calendar', 'roles' => ['admin', 'doctor', 'patient', 'receptionist'], 'route' => 'appointments.index'],
        ['id' => 'inpatient', 'label' => 'Inpatient Care', 'icon' => 'bi-hospital', 'roles' => ['admin', 'doctor', 'nurse'], 'route' => 'inpatient.index'],
        ['id' => 'outpatient', 'label' => 'Outpatient Care', 'icon' => 'bi-heart-pulse', 'roles' => ['admin', 'doctor', 'nurse'], 'route' => 'outpatient.index'],
        ['id' => 'medical-records', 'label' => 'Medical Records', 'icon' => 'bi-file-text', 'roles' => ['admin', 'doctor', 'nurse', 'patient'], 'route' => 'medical-records.index'],
        ['id' => 'billing', 'label' => 'Billing & Payments', 'icon' => 'bi-credit-card', 'roles' => ['admin', 'billing', 'patient'], 'route' => 'billing.index'],
        ['id' => 'discharge', 'label' => 'Discharge Management', 'icon' => 'bi-clipboard-check', 'roles' => ['admin', 'doctor', 'nurse', 'billing'], 'route' => 'discharge.index'],
        ['id' => 'reports', 'label' => 'Reports & Analytics', 'icon' => 'bi-graph-up', 'roles' => ['admin'], 'route' => 'reports.index'],
        ['id' => 'staff', 'label' => 'Staff Management', 'icon' => 'bi-person-gear', 'roles' => ['admin'], 'route' => 'staff.index'],
        ['id' => 'settings', 'label' => 'Settings', 'icon' => 'bi-gear', 'roles' => ['admin', 'doctor', 'nurse', 'patient', 'receptionist', 'billing'], 'route' => 'settings.index'],
    ];
    
    $filteredNavItems = array_filter($navItems, function($item) use ($user) {
        return in_array($user->role, $item['roles']);
    });
@endphp

<div class="sidebar" id="sidebar">
    <div class="logo">
        <img src="{{ asset('images/Concord (1).png') }}" alt="Concord Logo" onerror="this.classList.add('d-none'); this.nextElementSibling.classList.remove('d-none');">
        <div class="logo-text d-none">Core 1</div>
    </div>

    <nav>
        @foreach($filteredNavItems as $item)
            <a href="{{ route($item['route']) }}" 
               class="{{ $currentRoute === $item['route'] || str_contains($currentRoute, $item['id']) ? 'active' : '' }}">
                <i class="bi {{ $item['icon'] }}"></i>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach

       <form id="logout-form" method="POST" action="{{ route('core.logout') }}" class="d-none">
            @csrf
        </form>

        <a href="#"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </a>
    </nav>
</div>
