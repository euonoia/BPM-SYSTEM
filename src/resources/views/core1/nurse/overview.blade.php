<div class="p-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}</h1>
        <p class="text-gray-600 mt-1">Nurse Dashboard Overview</p>
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
                    <i class="fas fa-user-injured text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['active_patients'] ?? 0 }}</div>
            <div class="text-sm text-gray-600 mt-1">Active Patients</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-plus text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['today_registrations'] ?? 0 }}</div>
            <div class="text-sm text-gray-600 mt-1">New Patients Today</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-medical text-orange-600 text-xl"></i>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['recent_records'] ?? 0 }}</div>
            <div class="text-sm text-gray-600 mt-1">Records This Week</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="{{ route('patients.index') }}" class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <div>
                    <div class="font-semibold text-gray-900 group-hover:text-blue-600">Patient Management</div>
                    <div class="text-sm text-gray-600">View and manage patients</div>
                </div>
            </div>
        </a>

        <a href="{{ route('inpatient.index') }}" class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                    <i class="fas fa-bed text-green-600 text-xl"></i>
                </div>
                <div>
                    <div class="font-semibold text-gray-900 group-hover:text-green-600">Inpatient Care</div>
                    <div class="text-sm text-gray-600">Manage inpatient services</div>
                </div>
            </div>
        </a>

        <a href="{{ route('medical-records.index') }}" class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                    <i class="fas fa-file-medical text-purple-600 text-xl"></i>
                </div>
                <div>
                    <div class="font-semibold text-gray-900 group-hover:text-purple-600">Medical Records</div>
                    <div class="text-sm text-gray-600">Access patient records</div>
                </div>
            </div>
        </a>
    </div>

    <!-- Today's Appointments -->
    @if(isset($todayAppointments) && $todayAppointments->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Today's Appointments</h2>
            <p class="text-sm text-gray-600 mt-1">Upcoming appointments scheduled for today</p>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($todayAppointments as $appointment)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-check text-blue-600"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">{{ $appointment->patient->name ?? 'N/A' }}</div>
                            <div class="text-sm text-gray-600">
                                <i class="fas fa-clock text-gray-400 mr-1"></i>
                                {{ $appointment->appointment_time ? \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') : 'N/A' }}
                                @if($appointment->doctor)
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-user-md text-gray-400 mr-1"></i>
                                    {{ $appointment->doctor->name }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ 
                        $appointment->status === 'scheduled' ? 'bg-blue-100 text-blue-800' :
                        ($appointment->status === 'completed' ? 'bg-green-100 text-green-800' :
                        ($appointment->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))
                    }}">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Recent Patients -->
    @if(isset($recentPatients) && $recentPatients->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Recent Patients</h2>
                    <p class="text-sm text-gray-600 mt-1">Recently registered patients</p>
                </div>
                <a href="{{ route('patients.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    View All
                </a>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($recentPatients as $patient)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                            {{ strtoupper(substr($patient->name, 0, 2)) }}
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">{{ $patient->name }}</div>
                            <div class="text-sm text-gray-600">
                                <span class="font-mono">{{ $patient->patient_id }}</span>
                                <span class="mx-2">•</span>
                                <span class="capitalize">{{ $patient->gender }}</span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('patients.show', $patient) }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
