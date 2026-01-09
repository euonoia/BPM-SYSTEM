<?php

namespace App\Http\Controllers\core1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InpatientController extends Controller
{
    public function index()
    {
        $stats = [
            'current_inpatients' => 4,
            'occupied' => 4,
            'discharges_today' => 2,
        ];

        $beds = [
            ['id' => 'ICU-01', 'type' => 'ICU', 'patient' => 'Alice Wilson', 'patient_id' => 'HMS-2025-00123', 'status' => 'critical', 'bg' => 'critical'],
            ['id' => 'ICU-02', 'type' => 'ICU', 'patient' => 'Available', 'status' => 'available', 'bg' => 'available'],
            ['id' => 'ICU-03', 'type' => 'ICU', 'patient' => 'David Martinez', 'patient_id' => 'HMS-2025-00124', 'status' => 'stable', 'bg' => 'stable'],
            ['id' => 'ICU-04', 'type' => 'ICU', 'patient' => 'Cleaning', 'status' => 'cleaning', 'bg' => 'cleaning'],
            ['id' => 'WARD-01', 'type' => 'General Ward', 'patient' => 'Sarah Thompson', 'patient_id' => 'HMS-2025-00125', 'status' => 'recovering', 'bg' => 'critical'],
            ['id' => 'WARD-02', 'type' => 'General Ward', 'patient' => 'Available', 'status' => 'available', 'bg' => 'available'],
            ['id' => 'WARD-03', 'type' => 'General Ward', 'patient' => 'Available', 'status' => 'available', 'bg' => 'available'],
            ['id' => 'WARD-04', 'type' => 'General Ward', 'patient' => 'James Wilson', 'patient_id' => 'HMS-2025-00126', 'status' => 'stable', 'bg' => 'critical'],
        ];

        $inpatients = [
            ['inpatient_id' => 'IP-0001', 'patient' => 'John Doe', 'bed' => 'BED-201', 'admission_date' => '12/10/2024', 'doctor' => 'Dr. Emily Chen', 'reason' => 'Fever', 'status' => 'Admitted'],
            ['inpatient_id' => 'IP-0002', 'patient' => 'Jane Smith', 'bed' => 'BED-202', 'admission_date' => '12/11/2024', 'doctor' => 'Dr. Wilson', 'reason' => 'Observation', 'status' => 'Admitted'],
            ['inpatient_id' => 'IP-0003', 'patient' => 'Robert Brown', 'bed' => 'BED-203', 'admission_date' => '12/12/2024', 'doctor' => 'Dr. Adams', 'reason' => 'Surgery', 'status' => 'Admitted'],
        ];

        $medications = [
            ['patient' => 'Alice Wilson', 'medication' => 'Aspirin', 'dosage' => '100mg', 'time' => '09:00 AM', 'status' => 'Administered', 'action' => 'View'],
            ['patient' => 'David Martinez', 'medication' => 'Metformin', 'dosage' => '500mg', 'time' => '10:00 AM', 'status' => 'Pending', 'action' => 'Administer'],
        ];

        return view('core1.inpatient.index', compact('stats', 'beds', 'inpatients', 'medications'));
    }
}

