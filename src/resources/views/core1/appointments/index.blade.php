@extends('layouts.app')

@section('title', 'Appointments')

@section('content')
<div class="p-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Appointments</h1>
            <p class="text-gray-600 mt-1">Manage and schedule appointments</p>
        </div>
        <a href="{{ route('appointments.create') }}" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus"></i>
            Book Appointment
        </a>
    </div>

    <!-- View Controls -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="?view={{ $view }}&date={{ date('Y-m', strtotime($currentDate . ' -1 month')) }}" class="p-2 hover:bg-gray-100 rounded-lg">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <h2 class="text-xl font-semibold text-gray-900">
                    {{ date('F Y', strtotime($currentDate)) }}
                </h2>
                <a href="?view={{ $view }}&date={{ date('Y-m', strtotime($currentDate . ' +1 month')) }}" class="p-2 hover:bg-gray-100 rounded-lg">
                    <i class="fas fa-chevron-right"></i>
                </a>
                <a href="?view={{ $view }}&date={{ date('Y-m') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm">
                    Today
                </a>
            </div>
            <div class="flex gap-2">
                @foreach(['month', 'week', 'day', 'list'] as $v)
                    <a href="?view={{ $v }}&date={{ $currentDate }}" 
                       class="px-4 py-2 rounded-lg capitalize {{ 
                           $view === $v 
                               ? 'bg-blue-600 text-white' 
                               : 'border border-gray-300 text-gray-700 hover:bg-gray-50' 
                       }}">
                        {{ $v }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- List View -->
    @if($view === 'list')
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date & Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Doctor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($appointments as $appointment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-calendar text-gray-400"></i>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $appointment->appointment_date->format('M d, Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500">{{ $appointment->appointment_time }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-user text-gray-400"></i>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $appointment->patient->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $appointment->patient->patient_id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $appointment->doctor->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $appointment->type }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ 
                                        $appointment->status === 'completed' ? 'bg-green-100 text-green-800' :
                                        $appointment->status === 'scheduled' ? 'bg-blue-100 text-blue-800' :
                                        $appointment->status === 'cancelled' ? 'bg-red-100 text-red-800' :
                                        'bg-gray-100 text-gray-800'
                                    }}">
                                        {{ $appointment->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex gap-2">
                                        <a href="{{ route('appointments.show', $appointment) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                        <a href="#" class="text-green-600 hover:text-green-900">Reschedule</a>
                                        <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Cancel</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No appointments found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <p class="text-center text-gray-500">Calendar view implementation would go here</p>
        </div>
    @endif
</div>
@endsection

