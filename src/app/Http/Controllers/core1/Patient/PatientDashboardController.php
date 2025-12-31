<?php

namespace App\Http\Controllers\core1\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\core1\Patient;
use App\Models\core1\Appointment;

class PatientDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $patient = Patient::where('email', $user->email)->first();
        
        $upcomingAppointments = Appointment::where('patient_id', $patient?->id ?? 0)
            ->where('appointment_date', '>=', today())
            ->where('status', 'scheduled')
            ->count();

        return view('core1.patient.dashboard', compact('upcomingAppointments'));
    }

    public function overview()
    {
        $user = auth()->user();
        $patient = Patient::where('email', $user->email)->first();
        
        $upcomingAppointments = Appointment::where('patient_id', $patient?->id ?? 0)
            ->where('appointment_date', '>=', today())
            ->where('status', 'scheduled')
            ->count();

        return view('core1.patient.overview', compact('upcomingAppointments'));
    }
}

