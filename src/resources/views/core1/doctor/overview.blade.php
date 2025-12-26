<div class="p-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Welcome back, Dr. {{ auth()->user()->name }}</h1>
        <p class="text-gray-600 mt-1">Your dashboard overview</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ $todayAppointments }}</div>
            <div class="text-sm text-gray-600">Today's Appointments</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ $upcomingAppointments }}</div>
            <div class="text-sm text-gray-600">Upcoming Appointments</div>
        </div>
    </div>
</div>

