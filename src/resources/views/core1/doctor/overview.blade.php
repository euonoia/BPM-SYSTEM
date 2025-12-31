<div class="p-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Welcome back, Dr. {{ auth()->user()->name }}</h1>
        <p class="text-gray-600 mt-1">Your dashboard overview</p>
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
                    <i class="fas fa-calendar-check text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['upcoming_appointments'] ?? 0 }}</div>
            <div class="text-sm text-gray-600 mt-1">Upcoming Appointments</div>
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
                    <i class="fas fa-file-medical text-orange-600 text-xl"></i>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['recent_records'] ?? 0 }}</div>
            <div class="text-sm text-gray-600 mt-1">Records This Week</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="{{ route('appointments.index') }}" class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                    <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                </div>
                <div>
                    <div class="font-semibold text-gray-900 group-hover:text-blue-600">View Appointments</div>
                    <div class="text-sm text-gray-600">Manage your schedule</div>
                </div>
            </div>
        </a>

        <a href="{{ route('medical-records.index') }}" class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                    <i class="fas fa-file-medical text-green-600 text-xl"></i>
                </div>
                <div>
                    <div class="font-semibold text-gray-900 group-hover:text-green-600">Medical Records</div>
                    <div class="text-sm text-gray-600">Access patient records</div>
                </div>
            </div>
        </a>

        <a href="{{ route('patients.index') }}" class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                    <i class="fas fa-user-injured text-purple-600 text-xl"></i>
                </div>
                <div>
                    <div class="font-semibold text-gray-900 group-hover:text-purple-600">Patient List</div>
                    <div class="text-sm text-gray-600">View all patients</div>
                </div>
            </div>
        </a>
    </div>

    <!-- Today's Appointments -->
    @if(isset($todayAppointments) && $todayAppointments->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Today's Appointments</h2>
            <p class="text-sm text-gray-600 mt-1">Your scheduled appointments for today</p>
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
                                @if($appointment->type)
                                    <span class="mx-2">•</span>
                                    <span class="capitalize">{{ $appointment->type }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ 
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
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6 p-6">
        <div class="text-center py-8">
            <i class="fas fa-calendar-times text-gray-300 text-4xl mb-4"></i>
            <p class="text-gray-600">No appointments scheduled for today</p>
        </div>
    </div>
    @endif

    <!-- Upcoming Appointments -->
    @if(isset($upcomingAppointments) && $upcomingAppointments->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Upcoming Appointments</h2>
                    <p class="text-sm text-gray-600 mt-1">Your next scheduled appointments</p>
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

    <!-- Recent Medical Records -->
    @if(isset($recentRecords) && $recentRecords->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Recent Medical Records</h2>
                    <p class="text-sm text-gray-600 mt-1">Your recently created records</p>
                </div>
                <a href="{{ route('medical-records.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    View All
                </a>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($recentRecords as $record)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-file-medical text-orange-600"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">{{ $record->patient->name ?? 'N/A' }}</div>
                            <div class="text-sm text-gray-600">
                                <span class="capitalize">{{ $record->record_type ?? 'N/A' }}</span>
                                <span class="mx-2">•</span>
                                {{ $record->record_date ? \Carbon\Carbon::parse($record->record_date)->format('M d, Y') : 'N/A' }}
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('medical-records.show', $record) }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
