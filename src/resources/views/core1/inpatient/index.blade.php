@extends('core1.layouts.app')

@section('title', 'Inpatient Management')

@section('content')
<div class="core1-container">
    <div class="core1-flex-between core1-header">
        <div>
            <h1 class="core1-title">Inpatient Management</h1>
            <p class="core1-subtitle">Manage admitted patients and bed allocation</p>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="core1-stats-grid">
        <div class="core1-stat-card">
            <div class="d-flex flex-col">
                <i class="bi bi-door-closed text-blue mb-10" style="font-size: 24px;"></i>
                <p class="core1-title">{{ $stats['current_inpatients'] }}</p>
                <p class="text-xs text-gray">Current Inpatients</p>
            </div>
        </div>
        
        <div class="core1-stat-card">
            <div class="d-flex flex-col">
                <i class="bi bi-activity text-red mb-10" style="font-size: 24px;"></i>
                <p class="core1-title">{{ $stats['occupied'] }}</p>
                <p class="text-xs text-gray">Bed Occupancies</p>
            </div>
        </div>
        
        <div class="core1-stat-card">
            <div class="d-flex flex-col">
                <i class="bi bi-bed-front text-green mb-10" style="font-size: 24px;"></i>
                <p class="core1-title">{{ $stats['discharges_today'] }}</p>
                <p class="text-xs text-gray">Discharges Today</p>
            </div>
        </div>
    </div>
    <div class="d-flex justify-end mt-15">
        <button class="core1-btn core1-btn-primary">
            <i class="bi bi-plus"></i>
            <span class="ml-10">Admit Patient</span>
        </button>
    </div>

    <!-- Tabs Section -->
    <div class="core1-card no-hover p-0 overflow-hidden mt-30">
        <div class="core1-tabs-header border-bottom">
            <button class="core1-tab-btn active" onclick="switchTab(event, 'inpatient-list')">
                <i class="bi bi-person-lines-fill mr-5"></i> Inpatient List
            </button>
            <button class="core1-tab-btn" onclick="switchTab(event, 'bed-allocation')">
                <i class="bi bi-bed-front mr-5"></i> Bed Allocation
            </button>
        </div>

        <div class="tab-content p-25">
            <!-- Inpatient List Tab -->
            <div id="inpatient-list" class="core1-tab-pane active">
                <h3 class="mb-20 text-sm font-bold">Admitted Patients</h3>
                <div class="core1-table-container shadow-none border">
                    <table class="core1-table">
                        <thead>
                            <tr>
                                <th>Inpatient ID</th>
                                <th>Patient</th>
                                <th>Bed</th>
                                <th>Admission Date</th>
                                <th>Doctor</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inpatients as $inp)
                                <tr>
                                    <td>{{ $inp['inpatient_id'] }}</td>
                                    <td><a href="#" class="text-blue">{{ $inp['patient'] }}</a></td>
                                    <td>
                                        <span class="core1-badge-teal">
                                            {{ $inp['bed'] }}
                                        </span>
                                    </td>
                                    <td>{{ $inp['admission_date'] }}</td>
                                    <td>{{ $inp['doctor'] }}</td>
                                    <td>{{ $inp['reason'] }}</td>
                                    <td>
                                        <span class="text-success font-bold">{{ $inp['status'] }}</span>
                                    </td>
                                    <td class="text-right">
                                        <i class="bi bi-eye text-blue mr-10 cursor-pointer"></i>
                                        <i class="bi bi-file-earmark-text text-gray cursor-pointer"></i>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Bed Allocation Tab -->
            <div id="bed-allocation" class="core1-tab-pane">
                <h3 class="mb-20 text-sm font-bold">Bed Status Overview</h3>
                <div class="core1-bed-grid">
                    @foreach($beds as $bed)
                        <div class="core1-bed-card {{ $bed['bg'] }}">
                            <div class="d-flex justify-between items-start mb-10">
                                <div>
                                    <div class="font-bold text-sm">{{ $bed['id'] }}</div>
                                    <div class="text-xs text-gray">{{ $bed['type'] }}</div>
                                </div>
                                <i class="bi bi-bed-front text-gray"></i>
                            </div>
                            
                            @if($bed['status'] !== 'available' && $bed['status'] !== 'cleaning')
                                <div class="text-sm font-medium">{{ $bed['patient'] }}</div>
                                <div class="text-xs text-gray mb-10">{{ $bed['patient_id'] }}</div>
                                <span class="core1-status-tag core1-tag-{{ $bed['status'] }}">{{ ucfirst($bed['status']) }}</span>
                            @else
                                <div class="text-center mt-10">
                                    <span class="core1-status-tag core1-tag-{{ $bed['status'] }}">{{ ucfirst($bed['status']) }}</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(evt, tabId) {
    // Hide all tab panes
    const tabPanes = document.getElementsByClassName('core1-tab-pane');
    for (let i = 0; i < tabPanes.length; i++) {
        tabPanes[i].classList.remove('active');
    }

    // Remove active class from all buttons
    const tabBtns = document.getElementsByClassName('core1-tab-btn');
    for (let i = 0; i < tabBtns.length; i++) {
        tabBtns[i].classList.remove('active');
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(tabId).classList.add('active');
    evt.currentTarget.classList.add('active');
}
</script>
@endsection
