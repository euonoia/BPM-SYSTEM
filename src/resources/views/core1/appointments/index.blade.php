@extends('core1.layouts.app')

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css' rel='stylesheet' />
<style>
    .fc {
        max-width: 100%;
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .fc-header-toolbar {
        margin-bottom: 2rem !important;
    }
    .fc-button-primary {
        background-color: var(--primary-color, #2563eb) !important;
        border-color: var(--primary-color, #2563eb) !important;
    }
    .fc-event {
        cursor: pointer;
        padding: 2px 5px;
        border-radius: 4px;
        border: none;
    }
    .fc-event-title {
        font-weight: 500;
        font-size: 0.85rem;
    }
    .fc-daygrid-event {
        white-space: normal !important;
    }
</style>
@endpush


@section('title', 'Appointments')

@section('content')
<div class="core1-container">
    <div class="core1-flex-between core1-header">
        <div>
            <h1 class="core1-title">Appointments</h1>
            <p class="core1-subtitle">Manage and schedule appointments</p>
        </div>
        <a href="{{ route('appointments.create') }}" class="core1-btn core1-btn-primary">
            <i class="fas fa-plus"></i>
            <span class="pl-20">Book Appointment</span>
        </a>
    </div>

    <!-- View Controls -->
    <div class="core1-card mb-30">
        <div class="core1-flex-between">
            <div class="core1-flex-gap-2">
                @php
                    $carbonDate = \Carbon\Carbon::parse($currentDate);
                    $prevDate = $carbonDate->copy();
                    $nextDate = $carbonDate->copy();

                    if ($view === 'day') {
                        $prevDate->subDay();
                        $nextDate->addDay();
                    } elseif ($view === 'week') {
                        $prevDate->subWeek();
                        $nextDate->addWeek();
                    } else {
                        $prevDate->subMonth();
                        $nextDate->addMonth();
                    }
                @endphp
                <a href="?view={{ $view }}&date={{ $prevDate->format('Y-m-d') }}" class="core1-btn core1-btn-outline" style="padding: 8px;">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <h2 class="core1-title" style="font-size: 20px; min-width: 150px; text-align: center;">
                    @if($view === 'day')
                        {{ $carbonDate->format('M d, Y') }}
                    @elseif($view === 'week')
                        Week of {{ $carbonDate->startOfWeek()->format('M d') }}
                    @else
                        {{ $carbonDate->format('F Y') }}
                    @endif
                </h2>
                <a href="?view={{ $view }}&date={{ $nextDate->format('Y-m-d') }}" class="core1-btn core1-btn-outline" style="padding: 8px;">
                    <i class="fas fa-chevron-right"></i>
                </a>
                <a href="?view={{ $view }}&date={{ date('Y-m-d') }}" class="core1-btn core1-btn-outline">
                    Today
                </a>
            </div>
            <div class="core1-flex-gap-2">
                @foreach(['month', 'week', 'day', 'list'] as $v)
                    <a href="?view={{ $v }}&date={{ $currentDate }}" 
                       class="core1-btn {{ $view === $v ? 'core1-btn-primary' : 'core1-btn-outline' }}"
                       style="text-transform: capitalize;">
                        {{ $v }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- List View -->
    @if($view === 'list')
        <div class="core1-table-container">
            <table class="core1-table">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr>
                            <td>
                                <div class="core1-flex-gap-2">
                                    <i class="fas fa-calendar text-gray"></i>
                                    <div>
                                        <div class="text-sm font-medium text-dark">
                                            {{ $appointment->appointment_date->format('M d, Y') }}
                                        </div>
                                        <div class="text-xs text-gray">{{ $appointment->appointment_time }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="core1-flex-gap-2">
                                    <i class="fas fa-user text-gray"></i>
                                    <div>
                                        <div class="text-sm font-medium text-dark">{{ $appointment->patient->name }}</div>
                                        <div class="text-xs text-gray">{{ $appointment->patient->patient_id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm text-dark">{{ $appointment->doctor->name }}</div>
                            </td>
                            <td>
                                <div class="text-sm text-dark">{{ $appointment->type }}</div>
                            </td>
                            <td>
                                <span class="core1-badge {{ 
                                    $appointment->status === 'completed' ? 'core1-badge-active' :
                                    ($appointment->status === 'cancelled' ? 'core1-badge-inactive' :
                                    'core1-badge-inactive')
                                }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex items-center justify-center gap-2">
                                    <a href="{{ route('appointments.show', $appointment) }}" class="btn-icon-action text-blue-500">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="d-flex m-0 bg-transparent">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon-action text-red-600">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-40 text-gray">No appointments found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @else
        <div class="core1-card" style="padding: 0; overflow: hidden;">
            <div id="calendar"></div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        if (!calendarEl) return;

        const viewMap = {
            'month': 'dayGridMonth',
            'week': 'timeGridWeek',
            'day': 'timeGridDay'
        };

        const currentView = '{{ $view }}';
        const initialView = viewMap[currentView] || 'dayGridMonth';
        const initialDate = '{{ $currentDate }}';

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: initialView,
            initialDate: initialDate.includes('-') && initialDate.split('-').length === 2 ? initialDate + '-01' : initialDate,
            headerToolbar: false, // We use our own header
            themeSystem: 'standard',
            events: [
                @foreach($appointments as $appointment)
                {
                    id: '{{ $appointment->id }}',
                    title: '{{ $appointment->patient->name }} - {{ $appointment->doctor->name }}',
                    start: '{{ $appointment->appointment_time->toIso8601String() }}',
                    end: '{{ $appointment->appointment_time->addMinutes(30)->toIso8601String() }}',
                    extendedProps: {
                        status: '{{ $appointment->status }}',
                        type: '{{ $appointment->type }}',
                        patient: '{{ $appointment->patient->name }}',
                        doctor: '{{ $appointment->doctor->name }}'
                    },
                    backgroundColor: '{{ 
                        $appointment->status === 'completed' ? '#10b981' : 
                        ($appointment->status === 'cancelled' ? '#ef4444' : '#3b82f6') 
                    }}',
                    borderColor: 'transparent'
                },
                @endforeach
            ],
            eventClick: function(info) {
                window.location.href = `/appointments/${info.event.id}`;
            },
            height: 'auto',
            allDaySlot: false,
            slotMinTime: '08:00:00',
            slotMaxTime: '19:00:00',
        });

        calendar.render();
    });
</script>
@endpush


