<?php

namespace App\Http\Controllers\core1\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\core1\Appointment;

class DoctorDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $todayAppointments = Appointment::where('doctor_id', $user->id)
            ->whereDate('appointment_date', today())
            ->count();
        
        $upcomingAppointments = Appointment::where('doctor_id', $user->id)
            ->where('appointment_date', '>=', today())
            ->where('status', 'scheduled')
            ->count();

        return view('core1.doctor.dashboard', compact('todayAppointments', 'upcomingAppointments'));
    }

    public function overview()
    {
        $user = auth()->user();
        $todayAppointments = Appointment::where('doctor_id', $user->id)
            ->whereDate('appointment_date', today())
            ->count();
        
        $upcomingAppointments = Appointment::where('doctor_id', $user->id)
            ->where('appointment_date', '>=', today())
            ->where('status', 'scheduled')
            ->count();

        return view('core1.doctor.overview', compact('todayAppointments', 'upcomingAppointments'));
    }
}

