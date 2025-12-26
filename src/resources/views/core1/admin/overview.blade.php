<div class="p-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}</h1>
        <p class="text-gray-600 mt-1">Here's what's happening in your hospital today</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <span class="text-green-600 text-sm flex items-center gap-1">
                    <i class="fas fa-arrow-up"></i>
                    +12%
                </span>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_patients']) }}</div>
            <div class="text-sm text-gray-600">Total Patients</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar text-green-600 text-xl"></i>
                </div>
                <span class="text-green-600 text-sm flex items-center gap-1">
                    <i class="fas fa-arrow-up"></i>
                    +8%
                </span>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ $stats['today_appointments'] }}</div>
            <div class="text-sm text-gray-600">Today's Appointments</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-bed text-purple-600 text-xl"></i>
                </div>
                <span class="text-gray-600 text-sm">{{ $stats['bed_occupancy']['percentage'] }}% occupied</span>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ $stats['bed_occupancy']['occupied'] }}/{{ $stats['bed_occupancy']['total'] }}</div>
            <div class="text-sm text-gray-600">Bed Occupancy</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-teal-600 text-xl"></i>
                </div>
                <span class="text-green-600 text-sm flex items-center gap-1">
                    <i class="fas fa-arrow-up"></i>
                    +15%
                </span>
            </div>
            <div class="text-2xl font-bold text-gray-900">${{ number_format($stats['monthly_revenue'] / 1000) }}K</div>
            <div class="text-sm text-gray-600">Monthly Revenue</div>
        </div>
    </div>

    <!-- Charts Placeholder -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-900 mb-4">Patient Admissions</h3>
            <div class="h-64 flex items-center justify-center text-gray-500">
                <p>Chart visualization would go here (using Chart.js or similar)</p>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-900 mb-4">Monthly Revenue</h3>
            <div class="h-64 flex items-center justify-center text-gray-500">
                <p>Chart visualization would go here (using Chart.js or similar)</p>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Alerts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-900 mb-4">Recent Activities</h3>
            <div class="space-y-4">
                @forelse($recentActivities ?? [] as $activity)
                    <div class="flex items-start gap-3 pb-3 border-b border-gray-100 last:border-0">
                        <div class="w-2 h-2 bg-blue-600 rounded-full mt-2"></div>
                        <div class="flex-1">
                            <div class="text-sm text-gray-900">{{ $activity['action'] }}</div>
                            <div class="text-xs text-gray-500">{{ $activity['patient'] }} • {{ $activity['time'] }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No recent activities</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-900 mb-4">Alerts & Notifications</h3>
            <div class="space-y-4">
                @forelse($alerts ?? [] as $alert)
                    <div class="flex items-start gap-3 p-3 rounded-lg {{ 
                        $alert['priority'] === 'high' ? 'bg-red-50' : 
                        ($alert['priority'] === 'medium' ? 'bg-yellow-50' : 'bg-blue-50') 
                    }}">
                        <i class="fas fa-exclamation-circle mt-0.5 {{ 
                            $alert['priority'] === 'high' ? 'text-red-600' : 
                            ($alert['priority'] === 'medium' ? 'text-yellow-600' : 'text-blue-600') 
                        }}"></i>
                        <div class="flex-1">
                            <div class="text-sm text-gray-900">{{ $alert['message'] }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No alerts at this time</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

