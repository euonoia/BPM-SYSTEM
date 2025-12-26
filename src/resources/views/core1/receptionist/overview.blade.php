<div class="p-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}</h1>
        <p class="text-gray-600 mt-1">Receptionist Dashboard</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="text-2xl font-bold text-gray-900">{{ $todayAppointments }}</div>
            <div class="text-sm text-gray-600">Today's Appointments</div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="text-2xl font-bold text-gray-900">{{ $todayRegistrations }}</div>
            <div class="text-sm text-gray-600">Today's Registrations</div>
        </div>
    </div>
</div>

