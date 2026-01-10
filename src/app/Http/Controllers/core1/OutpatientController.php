<?php

namespace App\Http\Controllers\core1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OutpatientController extends Controller
{
    public function index()
    {
        $stats = [
            'my_appointments' => 8,
            'consulted' => 5,
            'pending_results' => 3,
            'avg_consultation_time' => '12 min',
        ];

        $appointments = [
            ['time' => '09:30 AM', 'patient' => 'Michael Chen', 'id' => 'OP-2025-002', 'doctor' => 'Dr. Chen', 'department' => 'Cardiology', 'status' => 'In Consultation', 'type' => 'new'],
            ['time' => '10:00 AM', 'patient' => 'Emma Thompson', 'id' => 'OP-2025-003', 'doctor' => 'Dr. Chen', 'department' => 'Cardiology', 'status' => 'Waiting', 'type' => 'follow-up'],
            ['time' => '11:00 AM', 'patient' => 'Sarah Johnson', 'id' => 'OP-2025-004', 'doctor' => 'Dr. Chen', 'department' => 'Cardiology', 'status' => 'Scheduled', 'type' => 'review'],
        ];

        $registrations = [
            ['date' => '08:30 AM', 'patient' => 'Michael Chen', 'id' => 'OP-2025-002', 'triage' => 'Stable - BP 140/90', 'status' => 'Triaged'],
            ['date' => '09:15 AM', 'patient' => 'Emma Thompson', 'id' => 'OP-2025-003', 'triage' => 'Stable - BP 120/80', 'status' => 'Triaged'],
        ];

        $prescriptions = [
            ['date' => 'Today', 'patient' => 'Michael Chen', 'medication' => 'Atorvastatin 20mg', 'dosage' => 'Once daily (Night)', 'instructions' => 'Post-meal'],
            ['date' => 'Today', 'patient' => 'Emma Thompson', 'medication' => 'Lisinopril 10mg', 'dosage' => 'Once daily (Morning)', 'instructions' => 'Avoid potassium-rich foods'],
        ];

        $diagnosticOrders = [
            ['date' => 'Today', 'patient' => 'Michael Chen', 'test' => 'Lipid Profile', 'clinical_note' => 'Suspected Hyperlipidemia', 'status' => 'Ordered'],
            ['date' => 'Yesterday', 'patient' => 'Sarah Johnson', 'test' => 'ECG', 'clinical_note' => 'Routine follow-up', 'status' => 'Result Ready'],
        ];

        $followUps = [
            ['patient' => 'Michael Chen', 'next_visit' => '2 weeks', 'doctor' => 'Dr. Chen', 'reason' => 'Evaluate medication response'],
            ['patient' => 'Emma Thompson', 'next_visit' => '1 month', 'doctor' => 'Dr. Chen', 'reason' => 'Routine cardiac review'],
        ];

        return view('core1.outpatient.index', compact('stats', 'appointments', 'registrations', 'prescriptions', 'diagnosticOrders', 'followUps'));
    }
}

