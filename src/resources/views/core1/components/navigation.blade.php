@php
    $user = auth()->user();
    $currentRoute = request()->route()->getName();
    
    $navItems = [
        ['id' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'fa-gauge', 'roles' => ['admin', 'doctor', 'nurse', 'patient', 'receptionist', 'billing'], 'route' => $user->role . '.dashboard'],
        ['id' => 'patients', 'label' => 'Patient Management', 'icon' => 'fa-users', 'roles' => ['admin', 'doctor', 'nurse', 'receptionist'], 'route' => 'patients.index'],
        ['id' => 'appointments', 'label' => 'Appointments', 'icon' => 'fa-calendar', 'roles' => ['admin', 'doctor', 'patient', 'receptionist'], 'route' => 'appointments.index'],
        ['id' => 'inpatient', 'label' => 'Inpatient Care', 'icon' => 'fa-bed', 'roles' => ['admin', 'doctor', 'nurse'], 'route' => 'inpatient.index'],
        ['id' => 'outpatient', 'label' => 'Outpatient Care', 'icon' => 'fa-stethoscope', 'roles' => ['admin', 'doctor', 'nurse'], 'route' => 'outpatient.index'],
        ['id' => 'medical-records', 'label' => 'Medical Records', 'icon' => 'fa-file-text', 'roles' => ['admin', 'doctor', 'nurse', 'patient'], 'route' => 'medical-records.index'],
        ['id' => 'billing', 'label' => 'Billing & Payments', 'icon' => 'fa-credit-card', 'roles' => ['admin', 'billing', 'patient'], 'route' => 'billing.index'],
        ['id' => 'discharge', 'label' => 'Discharge Management', 'icon' => 'fa-clipboard-list', 'roles' => ['admin', 'doctor', 'nurse', 'billing'], 'route' => 'discharge.index'],
        ['id' => 'reports', 'label' => 'Reports & Analytics', 'icon' => 'fa-chart-line', 'roles' => ['admin', 'doctor'], 'route' => 'reports.index'],
        ['id' => 'staff', 'label' => 'Staff Management', 'icon' => 'fa-user-cog', 'roles' => ['admin'], 'route' => 'staff.index'],
        ['id' => 'settings', 'label' => 'Settings', 'icon' => 'fa-cog', 'roles' => ['admin', 'doctor', 'nurse', 'patient', 'receptionist', 'billing'], 'route' => 'settings.index'],
    ];
    
    $filteredNavItems = array_filter($navItems, function($item) use ($user) {
        return in_array($user->role, $item['roles']);
    });
@endphp

<div class="bg-white border-r border-gray-200 w-64 min-h-screen flex flex-col">
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center gap-3">
            <i class="fas fa-hospital text-blue-600 text-2xl"></i>
            <div>
                <div class="font-bold text-gray-900">HMS</div>
                <div class="text-xs text-gray-500">Hospital System</div>
            </div>
        </div>
    </div>

    <div class="p-4 border-b border-gray-200">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                <span class="text-blue-600 font-semibold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-medium text-gray-900 truncate">{{ $user->name }}</div>
                <div class="text-xs text-gray-500 capitalize">{{ $user->role }}</div>
            </div>
        </div>
    </div>

    <nav class="flex-1 p-4 overflow-y-auto">
        <ul class="space-y-1">
            @foreach($filteredNavItems as $item)
                <li>
                    <a href="{{ route($item['route']) }}"
                       class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors {{ 
                           $currentRoute === $item['route'] || str_contains($currentRoute, $item['id'])
                               ? 'bg-blue-50 text-blue-600' 
                               : 'text-gray-700 hover:bg-gray-50' 
                       }}">
                        <i class="fas {{ $item['icon'] }} w-5 h-5"></i>
                        <span class="text-sm">{{ $item['label'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    <div class="p-4 border-t border-gray-200">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-red-600 hover:bg-red-50 transition-colors">
                <i class="fas fa-sign-out-alt w-5 h-5"></i>
                <span class="text-sm">Logout</span>
            </button>
        </form>
    </div>
</div>

