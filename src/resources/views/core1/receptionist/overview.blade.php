<div class="p-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}</h1>
        <p class="text-gray-600 mt-1">Receptionist Dashboard</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['today_appointments'] ?? 0 }}</div>
            <div class="text-sm text-gray-600 mt-1">Today's Appointments</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-plus text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['today_registrations'] ?? 0 }}</div>
            <div class="text-sm text-gray-600 mt-1">New Registrations Today</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['total_patients'] ?? 0 }}</div>
            <div class="text-sm text-gray-600 mt-1">Total Patients</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-orange-600 text-xl"></i>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['pending_appointments'] ?? 0 }}</div>
            <div class="text-sm text-gray-600 mt-1">Pending Appointments</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="{{ route('patients.create') }}" class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                    <i class="fas fa-user-plus text-blue-600 text-xl"></i>
                </div>
                <div>
                    <div class="font-semibold text-gray-900 group-hover:text-blue-600">Register Patient</div>
                    <div class="text-sm text-gray-600">Add a new patient</div>
                </div>
            </div>
        </a>

        <a href="{{ route('appointments.create') }}" class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                    <i class="fas fa-calendar-plus text-green-600 text-xl"></i>
                </div>
                <div>
                    <div class="font-semibold text-gray-900 group-hover:text-green-600">Book Appointment</div>
                    <div class="text-sm text-gray-600">Schedule an appointment</div>
                </div>
            </div>
        </a>

        <a href="{{ route('appointments.index') }}" class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                    <i class="fas fa-calendar-alt text-purple-600 text-xl"></i>
                </div>
                <div>
                    <div class="font-semibold text-gray-900 group-hover:text-purple-600">View Appointments</div>
                    <div class="text-sm text-gray-600">Manage appointments</div>
                </div>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Today's Appointments -->
        @if(isset($todayAppointments) && $todayAppointments->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Today's Appointments</h2>
                        <p class="text-sm text-gray-600 mt-1">Appointments scheduled for today</p>
                    </div>
                    <a href="{{ route('appointments.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        View All
                    </a>
                </div>
            </div>
            <div class="p-6 max-h-96 overflow-y-auto">
                <div class="space-y-3">
                    @foreach($todayAppointments as $appointment)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex items-center gap-3 flex-1">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-calendar-check text-blue-600 text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-medium text-gray-900 text-sm truncate">{{ $appointment->patient->name ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-600">
                                    {{ $appointment->appointment_time ? \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') : 'N/A' }}
                                    @if($appointment->doctor)
                                        <span class="mx-1">•</span>
                                        Dr. {{ $appointment->doctor->name }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full ml-2 flex-shrink-0 {{ 
                            $appointment->status === 'scheduled' ? 'bg-blue-100 text-blue-800' :
                            ($appointment->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                            ($appointment->status === 'completed' ? 'bg-gray-100 text-gray-800' :
                            ($appointment->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')))
                        }}">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="text-center py-8">
                <i class="fas fa-calendar-times text-gray-300 text-4xl mb-4"></i>
                <p class="text-gray-600">No appointments scheduled for today</p>
            </div>
        </div>
        @endif

        <!-- Recent Registrations -->
        @if(isset($recentRegistrations) && $recentRegistrations->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Recent Registrations</h2>
                        <p class="text-sm text-gray-600 mt-1">Newly registered patients</p>
                    </div>
                    <a href="{{ route('patients.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        View All
                    </a>
                </div>
            </div>
            <div class="p-6 max-h-96 overflow-y-auto">
                <div class="space-y-3">
                    @foreach($recentRegistrations as $patient)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex items-center gap-3 flex-1">
                            <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-white font-semibold text-xs flex-shrink-0">
                                {{ strtoupper(substr($patient->name, 0, 2)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-medium text-gray-900 text-sm truncate">{{ $patient->name }}</div>
                                <div class="text-xs text-gray-600">
                                    <span class="font-mono">{{ $patient->patient_id }}</span>
                                    <span class="mx-1">•</span>
                                    <span class="capitalize">{{ $patient->gender }}</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('patients.show', $patient) }}" class="text-blue-600 hover:text-blue-800 ml-2 flex-shrink-0">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="text-center py-8">
                <i class="fas fa-user-slash text-gray-300 text-4xl mb-4"></i>
                <p class="text-gray-600">No recent registrations</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Upcoming Appointments -->
    @if(isset($upcomingAppointments) && $upcomingAppointments->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Upcoming Appointments</h2>
                    <p class="text-sm text-gray-600 mt-1">Next scheduled appointments</p>
                </div>
                <a href="{{ route('appointments.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    View All
                </a>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($upcomingAppointments as $appointment)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar text-green-600"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">{{ $appointment->patient->name ?? 'N/A' }}</div>
                            <div class="text-sm text-gray-600">
                                <i class="fas fa-calendar-alt text-gray-400 mr-1"></i>
                                {{ $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') : 'N/A' }}
                                <span class="mx-2">•</span>
                                <i class="fas fa-clock text-gray-400 mr-1"></i>
                                {{ $appointment->appointment_time ? \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') : 'N/A' }}
                                @if($appointment->doctor)
                                    <span class="mx-2">•</span>
                                    Dr. {{ $appointment->doctor->name }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
