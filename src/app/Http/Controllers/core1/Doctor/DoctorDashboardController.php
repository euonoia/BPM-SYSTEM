<?php

namespace App\Http\Controllers\core1\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\core1\Appointment;
use App\Models\core1\Patient;
use App\Models\core1\MedicalRecord;

class DoctorDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Statistics
        $stats = [
            'today_appointments' => Appointment::where('doctor_id', $user->id)
                ->whereDate('appointment_date', today())
                ->count(),
            'upcoming_appointments' => Appointment::where('doctor_id', $user->id)
                ->where('appointment_date', '>=', today())
                ->where('status', 'scheduled')
                ->count(),
            'total_patients' => Patient::whereHas('appointments', function($query) use ($user) {
                $query->where('doctor_id', $user->id);
            })->distinct()->count(),
            'recent_records' => MedicalRecord::where('doctor_id', $user->id)
                ->whereDate('created_at', '>=', now()->subDays(7))
                ->count(),
        ];
        
        // Today's appointments with details
        $todayAppointments = Appointment::with(['patient'])
            ->where('doctor_id', $user->id)
            ->whereDate('appointment_date', today())
            ->orderBy('appointment_time')
            ->get();
        
        // Upcoming appointments (next 5)
        $upcomingAppointments = Appointment::with(['patient'])
            ->where('doctor_id', $user->id)
            ->where('appointment_date', '>=', today())
            ->where('status', 'scheduled')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->take(5)
            ->get();
        
        // Recent medical records
        $recentRecords = MedicalRecord::with(['patient'])
            ->where('doctor_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('core1.doctor.dashboard', compact('stats', 'todayAppointments', 'upcomingAppointments', 'recentRecords'));
    }

    public function overview()
    {
        $user = auth()->user();
        
        $stats = [
            'today_appointments' => Appointment::where('doctor_id', $user->id)
                ->whereDate('appointment_date', today())
                ->count(),
            'upcoming_appointments' => Appointment::where('doctor_id', $user->id)
                ->where('appointment_date', '>=', today())
                ->where('status', 'scheduled')
                ->count(),
            'total_patients' => Patient::whereHas('appointments', function($query) use ($user) {
                $query->where('doctor_id', $user->id);
            })->distinct()->count(),
            'recent_records' => MedicalRecord::where('doctor_id', $user->id)
                ->whereDate('created_at', '>=', now()->subDays(7))
                ->count(),
        ];
        
        $todayAppointments = Appointment::with(['patient'])
            ->where('doctor_id', $user->id)
            ->whereDate('appointment_date', today())
            ->orderBy('appointment_time')
            ->get();
        
        $upcomingAppointments = Appointment::with(['patient'])
            ->where('doctor_id', $user->id)
            ->where('appointment_date', '>=', today())
            ->where('status', 'scheduled')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->take(5)
            ->get();
        
        $recentRecords = MedicalRecord::with(['patient'])
            ->where('doctor_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('core1.doctor.overview', compact('stats', 'todayAppointments', 'upcomingAppointments', 'recentRecords'));
    }
}

