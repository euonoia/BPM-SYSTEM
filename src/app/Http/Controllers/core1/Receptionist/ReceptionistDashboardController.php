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
        $todayAppointments = Appointment::whereDate('appointment_date', today())->count();
        $todayRegistrations = Patient::whereDate('created_at', today())->count();

        return view('core1.receptionist.dashboard', compact('todayAppointments', 'todayRegistrations'));
    }

    public function overview()
    {
        $todayAppointments = Appointment::whereDate('appointment_date', today())->count();
        $todayRegistrations = Patient::whereDate('created_at', today())->count();

        return view('core1.receptionist.overview', compact('todayAppointments', 'todayRegistrations'));
    }
}

