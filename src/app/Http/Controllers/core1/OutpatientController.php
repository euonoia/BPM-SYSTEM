<?php

namespace App\Http\Controllers\core1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OutpatientController extends Controller
{
    public function index()
    {
        $stats = [
            'today_appointments' => 12,
            'completed' => 8,
            'waiting' => 4,
            'avg_wait_time' => '15 min',
        ];

        $appointments = [
            ['time' => '09:00 AM', 'patient' => 'Sarah Johnson', 'id' => 'OP-2025-001', 'doctor' => 'Dr. Emily Chen', 'department' => 'Cardiology', 'status' => 'Arrived', 'type' => 'follow-up'],
            ['time' => '09:30 AM', 'patient' => 'Michael Chen', 'id' => 'OP-2025-002', 'doctor' => 'Dr. Wilson', 'department' => 'Dermatology', 'status' => 'In Consultation', 'type' => 'new'],
            ['time' => '10:00 AM', 'patient' => 'Emma Thompson', 'id' => 'OP-2025-003', 'doctor' => 'Dr. Emily Chen', 'department' => 'Cardiology', 'status' => 'Waiting', 'type' => 'follow-up'],
            ['time' => '10:30 AM', 'patient' => 'David Miller', 'id' => 'OP-2025-004', 'doctor' => 'Dr. Adams', 'department' => 'General Medicine', 'status' => 'Scheduled', 'type' => 'new'],
            ['time' => '11:00 AM', 'patient' => 'Olivia White', 'id' => 'OP-2025-005', 'doctor' => 'Dr. Wilson', 'department' => 'Dermatology', 'status' => 'Scheduled', 'type' => 'follow-up'],
        ];

        return view('core1.outpatient.index', compact('stats', 'appointments'));
    }
}

