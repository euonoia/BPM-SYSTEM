<?php

namespace App\Http\Controllers\core1\Receptionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\core1\Appointment;
use App\Models\core1\Patient;

class ReceptionistDashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $stats = [
            'today_appointments' => Appointment::whereDate('appointment_date', today())->count(),
            'today_registrations' => Patient::whereDate('created_at', today())->count(),
            'total_patients' => Patient::count(),
            'pending_appointments' => Appointment::where('status', 'scheduled')
                ->where('appointment_date', '>=', today())
                ->count(),
        ];
        
        // Today's appointments
        $todayAppointments = Appointment::with(['patient', 'doctor'])
            ->whereDate('appointment_date', today())
            ->orderBy('appointment_time')
            ->take(10)
            ->get();
        
        // Recent patient registrations
        $recentRegistrations = Patient::latest()
            ->take(10)
            ->get();
        
        // Upcoming appointments (next 5)
        $upcomingAppointments = Appointment::with(['patient', 'doctor'])
            ->where('appointment_date', '>=', today())
            ->where('status', 'scheduled')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->take(5)
            ->get();

        return view('core1.receptionist.dashboard', compact('stats', 'todayAppointments', 'recentRegistrations', 'upcomingAppointments'));
    }

    public function overview()
    {
        $stats = [
            'today_appointments' => Appointment::whereDate('appointment_date', today())->count(),
            'today_registrations' => Patient::whereDate('created_at', today())->count(),
            'total_patients' => Patient::count(),
            'pending_appointments' => Appointment::where('status', 'scheduled')
                ->where('appointment_date', '>=', today())
                ->count(),
        ];
        
        $todayAppointments = Appointment::with(['patient', 'doctor'])
            ->whereDate('appointment_date', today())
            ->orderBy('appointment_time')
            ->take(10)
            ->get();
        
        $recentRegistrations = Patient::latest()
            ->take(10)
            ->get();
        
        $upcomingAppointments = Appointment::with(['patient', 'doctor'])
            ->where('appointment_date', '>=', today())
            ->where('status', 'scheduled')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->take(5)
            ->get();

        return view('core1.receptionist.overview', compact('stats', 'todayAppointments', 'recentRegistrations', 'upcomingAppointments'));
    }
}

