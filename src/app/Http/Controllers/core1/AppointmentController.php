<?php

namespace App\Http\Controllers\core1;

use App\Http\Controllers\Controller;
use App\Models\core1\Appointment;
use App\Models\core1\Patient;
use App\Models\core1\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $view = $request->get('view', 'month');
        $currentDate = $request->get('date', now()->format('Y-m'));
        
        $appointments = Appointment::with(['patient', 'doctor'])
            ->whereYear('appointment_date', date('Y', strtotime($currentDate)))
            ->whereMonth('appointment_date', date('m', strtotime($currentDate)))
            ->get();
        
        $patients = Patient::all();
        $doctors = User::where('role', 'doctor')->get();
        
        return view('core1.appointments.index', compact('appointments', 'view', 'currentDate', 'patients', 'doctors'));
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = User::where('role', 'doctor')->get();
        
        return view('core1.appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'type' => 'required|string',
            'reason' => 'nullable|string',
        ]);

        $validated['appointment_id'] = 'APT-' . str_pad(Appointment::count() + 1, 3, '0', STR_PAD_LEFT);
        $validated['status'] = 'scheduled';

        Appointment::create($validated);

        return redirect()->route('appointments.index')->with('success', 'Appointment booked successfully.');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor']);
        return view('core1.appointments.show', compact('appointment'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:scheduled,completed,cancelled,no-show',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($validated);

        return redirect()->back()->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Appointment cancelled successfully.');
    }
}

