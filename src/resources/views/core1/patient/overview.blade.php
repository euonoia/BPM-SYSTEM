<div class="p-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}</h1>
        <p class="text-gray-600 mt-1">Your patient portal</p>
    </div>

    @if(isset($patient))
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['upcoming_appointments'] ?? 0 }}</div>
            <div class="text-sm text-gray-600 mt-1">Upcoming Appointments</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['total_appointments'] ?? 0 }}</div>
            <div class="text-sm text-gray-600 mt-1">Total Appointments</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-medical text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['medical_records'] ?? 0 }}</div>
            <div class="text-sm text-gray-600 mt-1">Medical Records</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-invoice-dollar text-orange-600 text-xl"></i>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['pending_bills'] ?? 0 }}</div>
            <div class="text-sm text-gray-600 mt-1">Pending Bills</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="{{ route('appointments.create') }}" class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                    <i class="fas fa-calendar-plus text-blue-600 text-xl"></i>
                </div>
                <div>
                    <div class="font-semibold text-gray-900 group-hover:text-blue-600">Book Appointment</div>
                    <div class="text-sm text-gray-600">Schedule a new appointment</div>
                </div>
            </div>
        </a>

        <a href="{{ route('medical-records.index') }}" class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                    <i class="fas fa-file-medical text-green-600 text-xl"></i>
                </div>
                <div>
                    <div class="font-semibold text-gray-900 group-hover:text-green-600">View Records</div>
                    <div class="text-sm text-gray-600">Access your medical records</div>
                </div>
            </div>
        </a>

        <a href="{{ route('billing.index') }}" class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                    <i class="fas fa-file-invoice text-purple-600 text-xl"></i>
                </div>
                <div>
                    <div class="font-semibold text-gray-900 group-hover:text-purple-600">View Bills</div>
                    <div class="text-sm text-gray-600">Check your bills and payments</div>
                </div>
            </div>
        </a>
    </div>

    <!-- Upcoming Appointments -->
    @if(isset($upcomingAppointments) && $upcomingAppointments->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Upcoming Appointments</h2>
                    <p class="text-sm text-gray-600 mt-1">Your scheduled appointments</p>
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
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-check text-blue-600"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">
                                @if($appointment->doctor)
                                    Dr. {{ $appointment->doctor->name }}
                                @else
                                    Appointment
                                @endif
                            </div>
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
    @else
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6 p-6">
        <div class="text-center py-8">
            <i class="fas fa-calendar-times text-gray-300 text-4xl mb-4"></i>
            <p class="text-gray-600 mb-4">No upcoming appointments</p>
            <a href="{{ route('appointments.create') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Book an Appointment
            </a>
        </div>
    </div>
    @endif

    <!-- Recent Medical Records -->
    @if(isset($recentRecords) && $recentRecords->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Recent Medical Records</h2>
                    <p class="text-sm text-gray-600 mt-1">Your recent medical records</p>
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
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-file-medical text-purple-600"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">
                                <span class="capitalize">{{ $record->record_type ?? 'Record' }}</span>
                                @if($record->doctor)
                                    <span class="text-gray-600"> - Dr. {{ $record->doctor->name }}</span>
                                @endif
                            </div>
                            <div class="text-sm text-gray-600">
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

    <!-- Pending Bills -->
    @if(isset($pendingBills) && $pendingBills->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Pending Bills</h2>
                    <p class="text-sm text-gray-600 mt-1">Bills awaiting payment</p>
                </div>
                <a href="{{ route('billing.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    View All
                </a>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($pendingBills as $bill)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-file-invoice-dollar text-orange-600"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">{{ $bill->bill_number ?? 'N/A' }}</div>
                            <div class="text-sm text-gray-600">
                                <i class="fas fa-calendar text-gray-400 mr-1"></i>
                                {{ $bill->bill_date ? \Carbon\Carbon::parse($bill->bill_date)->format('M d, Y') : 'N/A' }}
                                @if($bill->due_date)
                                    <span class="mx-2">•</span>
                                    Due: {{ \Carbon\Carbon::parse($bill->due_date)->format('M d, Y') }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <div class="font-semibold text-gray-900">${{ number_format($bill->total ?? 0, 2) }}</div>
                        </div>
                        <a href="{{ route('billing.show', $bill) }}" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    @else
    <!-- No Patient Profile -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <div class="text-center py-8">
            <i class="fas fa-user-slash text-gray-300 text-4xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Patient Profile Not Found</h3>
            <p class="text-gray-600 mb-4">Your account is not linked to a patient profile. Please contact the receptionist to register as a patient.</p>
        </div>
    </div>
    @endif
</div>
