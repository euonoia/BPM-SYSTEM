<?php

namespace App\Http\Controllers\core1\Nurse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\core1\Patient;
use App\Models\core1\Appointment;
use App\Models\core1\MedicalRecord;

class NurseDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Statistics for nurse dashboard
        $stats = [
            'today_appointments' => Appointment::whereDate('appointment_date', today())->count(),
            'active_patients' => Patient::where('status', 'active')->count(),
            'today_registrations' => Patient::whereDate('created_at', today())->count(),
            'recent_records' => MedicalRecord::whereDate('created_at', '>=', now()->subDays(7))->count(),
        ];
        
        // Recent appointments for today
        $todayAppointments = Appointment::with(['patient', 'doctor'])
            ->whereDate('appointment_date', today())
            ->orderBy('appointment_time')
            ->take(5)
            ->get();
        
        // Recent patients
        $recentPatients = Patient::latest()
            ->take(5)
            ->get();
        
        return view('core1.nurse.dashboard', compact('stats', 'todayAppointments', 'recentPatients'));
    }

    public function overview()
    {
        $user = auth()->user();
        
        // Statistics for nurse dashboard
        $stats = [
            'today_appointments' => Appointment::whereDate('appointment_date', today())->count(),
            'active_patients' => Patient::where('status', 'active')->count(),
            'today_registrations' => Patient::whereDate('created_at', today())->count(),
            'recent_records' => MedicalRecord::whereDate('created_at', '>=', now()->subDays(7))->count(),
        ];
        
        // Recent appointments for today
        $todayAppointments = Appointment::with(['patient', 'doctor'])
            ->whereDate('appointment_date', today())
            ->orderBy('appointment_time')
            ->take(5)
            ->get();
        
        // Recent patients
        $recentPatients = Patient::latest()
            ->take(5)
            ->get();
        
        return view('core1.nurse.overview', compact('stats', 'todayAppointments', 'recentPatients'));
    }
}

