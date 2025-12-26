@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
<div class="p-8">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Appointment Details</h1>
                <p class="text-gray-600 mt-1">View appointment information</p>
            </div>
            <a href="{{ route('appointments.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                Back to List
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 max-w-2xl">
        <div class="space-y-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Appointment ID</label>
                    <p class="text-gray-900 font-semibold">{{ $appointment->appointment_id }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ 
                        $appointment->status === 'completed' ? 'bg-green-100 text-green-800' :
                        $appointment->status === 'scheduled' ? 'bg-blue-100 text-blue-800' :
                        $appointment->status === 'cancelled' ? 'bg-red-100 text-red-800' :
                        'bg-gray-100 text-gray-800'
                    }}">
                        {{ $appointment->status }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Patient</label>
                    <p class="text-gray-900">{{ $appointment->patient->name }}</p>
                    <p class="text-sm text-gray-500">{{ $appointment->patient->patient_id }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Doctor</label>
                    <p class="text-gray-900">{{ $appointment->doctor->name }}</p>
                    @if($appointment->doctor->specialization)
                        <p class="text-sm text-gray-500">{{ $appointment->doctor->specialization }}</p>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <p class="text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                    <p class="text-gray-900">{{ $appointment->appointment_time }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <p class="text-gray-900">{{ $appointment->type }}</p>
                </div>
            </div>

            @if($appointment->reason)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                <p class="text-gray-900">{{ $appointment->reason }}</p>
            </div>
            @endif

            @if($appointment->notes)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                <p class="text-gray-900">{{ $appointment->notes }}</p>
            </div>
            @endif

            <div class="pt-6 border-t border-gray-200">
                <form action="{{ route('appointments.update', $appointment) }}" method="POST" class="flex gap-4">
                    @csrf
                    @method('PUT')
                    <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="scheduled" {{ $appointment->status === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="completed" {{ $appointment->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $appointment->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="no-show" {{ $appointment->status === 'no-show' ? 'selected' : '' }}>No Show</option>
                    </select>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

