@extends('core1.layouts.app')

@section('title', 'Doctor | Outpatient Management')

@section('content')
<div class="core1-container">
    <div class="core1-flex-between core1-header">
        <div>
            <h1 class="core1-title">Doctor's Clinical Workspace</h1>
            <p class="core1-subtitle">Review schedules, prescribe treatments, and manage clinical outcomes</p>
        </div>
        <div class="d-flex gap-2">
            <button class="core1-btn core1-btn-outline">
                <i class="bi bi-clock-history"></i>
                <span class="ml-10">My History</span>
            </button>
            <button class="core1-btn core1-btn-primary">
                <i class="bi bi-play-fill"></i>
                <span class="ml-10">Next Consultation</span>
            </button>
        </div>
    </div>

    <!-- Clinical Stats Grid -->
    <div class="core1-stats-grid">
        <div class="core1-stat-card">
            <div class="d-flex flex-col">
                <i class="bi bi-calendar-check text-blue mb-10" style="font-size: 24px;"></i>
                <p class="core1-title">{{ $stats['my_appointments'] }}</p>
                <p class="text-xs text-gray">My Appointments</p>
            </div>
        </div>
        
        <div class="core1-stat-card">
            <div class="d-flex flex-col">
                <i class="bi bi-person-check text-green mb-10" style="font-size: 24px;"></i>
                <p class="core1-title">{{ $stats['consulted'] }}</p>
                <p class="text-xs text-gray">Patients Consulted Today</p>
            </div>
        </div>
        
        <div class="core1-stat-card">
            <div class="d-flex flex-col">
                <i class="bi bi-clipboard-pulse text-orange mb-10" style="font-size: 24px;"></i>
                <p class="core1-title">{{ $stats['pending_results'] }}</p>
                <p class="text-xs text-gray">Pending Lab Results</p>
            </div>
        </div>

        <div class="core1-stat-card">
            <div class="d-flex flex-col">
                <i class="bi bi-stopwatch text-blue mb-10" style="font-size: 24px;"></i>
                <p class="core1-title">{{ $stats['avg_consultation_time'] }}</p>
                <p class="text-xs text-gray">Avg. Consultation</p>
            </div>
        </div>
    </div>

    <!-- Clinical Workflow Tabs -->
    <div class="core1-card no-hover p-0 overflow-hidden mt-30">
        <div class="core1-tabs-header border-bottom">
            <button class="core1-tab-btn active" onclick="switchTab(event, 'consultation-tracking')">
                <i class="bi bi-activity mr-5"></i> Consultation Tracking
            </button>
            <button class="core1-tab-btn" onclick="switchTab(event, 'arrival-logs')">
                <i class="bi bi-journal-check mr-5"></i> Arrival Logs & Triage
            </button>
            <button class="core1-tab-btn" onclick="switchTab(event, 'prescription-recording')">
                <i class="bi bi-capsule mr-5"></i> Prescription & Treatment
            </button>
            <button class="core1-tab-btn" onclick="switchTab(event, 'diagnostic-orders')">
                <i class="bi bi-clipboard-pulse mr-5"></i> Diagnostic Orders
            </button>
            <button class="core1-tab-btn" onclick="switchTab(event, 'follow-up')">
                <i class="bi bi-calendar-check mr-5"></i> Follow Up
            </button>
        </div>

        <div class="tab-content p-25">
            <!-- Consultation Tracking Tab -->
            <div id="consultation-tracking" class="core1-tab-pane active">
                <div class="d-flex justify-between items-center mb-20">
                    <h3 class="core1-title" style="font-size: 18px;">Active Queue</h3>
                    <div style="position: relative; width: 300px;">
                        <i class="bi bi-search" style="position: absolute; left: 12px; top: 10px; color: #9ca3af;"></i>
                        <input type="text" placeholder="Search my patients..." 
                            style="width: 100%; padding: 8px 12px 8px 35px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); font-size: 14px;">
                    </div>
                </div>
                <div class="core1-table-container shadow-none border">
                    <table class="core1-table">
                        <thead>
                            <tr>
                                <th>APP. TIME</th>
                                <th>PATIENT</th>
                                <th>TYPE</th>
                                <th>STATUS</th>
                                <th class="text-right">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $apt)
                                <tr>
                                    <td class="font-bold">{{ $apt['time'] }}</td>
                                    <td>
                                        <div class="font-bold text-blue">{{ $apt['patient'] }}</div>
                                        <div class="text-xs text-gray">{{ $apt['id'] }}</div>
                                    </td>
                                    <td>
                                        <span class="core1-status-tag" style="background: #f3f4f6; color: #374151;">
                                            {{ ucfirst($apt['type']) }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = 'tag-pending';
                                            if($apt['status'] == 'Scheduled') $statusClass = 'core1-tag-recovering';
                                            if($apt['status'] == 'In Consultation') $statusClass = 'core1-tag-critical';
                                            if($apt['status'] == 'Waiting') $statusClass = 'core1-tag-cleaning';
                                        @endphp
                                        <span class="core1-status-tag {{ $statusClass }}">
                                            {{ $apt['status'] }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <button class="core1-btn-sm core1-btn-primary">Open Chart</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Arrival Logs & Triage Tab -->
            <div id="arrival-logs" class="core1-tab-pane">
                <h3 class="mb-20 text-sm font-bold">Patient Arrival & Triage Summary</h3>
                <div class="core1-table-container shadow-none border">
                    <table class="core1-table">
                        <thead>
                            <tr>
                                <th>ARRIVAL</th>
                                <th>PATIENT</th>
                                <th>TRIAGE NOTE / VITALS</th>
                                <th>STATUS</th>
                                <th class="text-right">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($registrations as $reg)
                                <tr>
                                    <td>{{ $reg['date'] }}</td>
                                    <td class="font-bold text-blue">{{ $reg['patient'] }}</td>
                                    <td>{{ $reg['triage'] }}</td>
                                    <td>
                                        <span class="core1-status-tag core1-tag-stable">
                                            {{ $reg['status'] }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <button class="core1-btn-sm core1-btn-outline">Review Vitals</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Prescription Recording Tab -->
            <div id="prescription-recording" class="core1-tab-pane">
                <div class="d-flex justify-between items-center mb-20">
                    <h3 class="core1-title" style="font-size: 18px;">Record Prescriptions</h3>
                    <button class="core1-btn core1-btn-primary">
                        <i class="bi bi-pencil-square"></i> New e-Prescription
                    </button>
                </div>
                <div class="core1-table-container shadow-none border">
                    <table class="core1-table">
                        <thead>
                            <tr>
                                <th>PATIENT</th>
                                <th>MEDICATION</th>
                                <th>DOSAGE</th>
                                <th>INSTRUCTIONS</th>
                                <th class="text-right">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prescriptions as $rx)
                                <tr>
                                    <td class="font-bold text-blue">{{ $rx['patient'] }}</td>
                                    <td class="font-medium">{{ $rx['medication'] }}</td>
                                    <td>{{ $rx['dosage'] }}</td>
                                    <td class="text-xs">{{ $rx['instructions'] }}</td>
                                    <td class="text-right">
                                        <i class="bi bi-printer mr-10 cursor-pointer" title="Print Rx"></i>
                                        <i class="bi bi-pencil cursor-pointer" title="Edit Rx"></i>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Diagnostic Orders Tab -->
            <div id="diagnostic-orders" class="core1-tab-pane">
                <div class="d-flex justify-between items-center mb-20">
                    <h3 class="core1-title" style="font-size: 18px;">Laboratory & Diagnostic Management</h3>
                    <button class="core1-btn core1-btn-primary">
                        <i class="bi bi-plus-circle"></i> Create Lab Order
                    </button>
                </div>
                <div class="core1-table-container shadow-none border">
                    <table class="core1-table">
                        <thead>
                            <tr>
                                <th>PATIENT</th>
                                <th>ORDERED TEST</th>
                                <th>CLINICAL INDICATION</th>
                                <th>STATUS</th>
                                <th class="text-right">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($diagnosticOrders as $order)
                                <tr>
                                    <td class="font-bold text-blue">{{ $order['patient'] }}</td>
                                    <td class="font-medium">{{ $order['test'] }}</td>
                                    <td class="text-xs">{{ $order['clinical_note'] }}</td>
                                    <td>
                                        <span class="core1-status-tag {{ $order['status'] == 'Ordered' ? 'core1-tag-cleaning' : 'core1-tag-stable' }}">
                                            {{ $order['status'] }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        @if($order['status'] == 'Result Ready')
                                            <button class="core1-btn-sm core1-btn-primary">Review Result</button>
                                        @else
                                            <button class="core1-btn-sm core1-btn-outline">Track Order</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Follow Up Tab -->
            <div id="follow-up" class="core1-tab-pane">
                <div class="d-flex justify-between items-center mb-20">
                    <h3 class="core1-title" style="font-size: 18px;">Planned Follow-up Visits</h3>
                </div>
                <div class="core1-table-container shadow-none border">
                    <table class="core1-table">
                        <thead>
                            <tr>
                                <th>TIMEFRAME</th>
                                <th>PATIENT</th>
                                <th>CLINICAL REASON</th>
                                <th class="text-right">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($followUps as $fu)
                                <tr>
                                    <td class="font-bold">{{ $fu['next_visit'] }}</td>
                                    <td class="font-bold text-blue">{{ $fu['patient'] }}</td>
                                    <td>{{ $fu['reason'] }}</td>
                                    <td class="text-right">
                                        <button class="core1-btn-sm core1-btn-outline">Modify Instructions</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(evt, tabId) {
    const tabPanes = document.getElementsByClassName('core1-tab-pane');
    for (let i = 0; i < tabPanes.length; i++) {
        tabPanes[i].classList.remove('active');
    }
    const tabBtns = document.getElementsByClassName('core1-tab-btn');
    for (let i = 0; i < tabBtns.length; i++) {
        tabBtns[i].classList.remove('active');
    }
    document.getElementById(tabId).classList.add('active');
    evt.currentTarget.classList.add('active');
}
</script>
@endsection
