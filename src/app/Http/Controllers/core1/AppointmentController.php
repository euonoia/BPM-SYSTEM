<?php

namespace App\Http\Controllers\core1;

use App\Http\Controllers\Controller;
use App\Models\core1\Appointment;
use App\Models\core1\Patient;
use App\Models\core1\User;
use App\Models\core1\WaitingList;
use App\Http\Requests\core1\Appointments\StoreAppointmentRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $view = $request->get('view', 'month');
        $currentDate = $request->get('date', now()->format('Y-m'));
        
        $query = Appointment::with(['patient', 'doctor']);
        
        if ($view === 'month') {
            $query->whereYear('appointment_date', date('Y', strtotime($currentDate)))
                  ->whereMonth('appointment_date', date('m', strtotime($currentDate)));
        } elseif ($view === 'day') {
            $query->whereDate('appointment_date', $currentDate);
        }
        
        $appointments = $query->orderBy('appointment_time')->get();
        
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

    public function store(StoreAppointmentRequest $request)
    {
        $validated = $request->validated();
        
        // Transform H:i to Y-m-d H:i:s
        $fullTime = $validated['appointment_date'] . ' ' . $validated['appointment_time'];
        $validated['appointment_time'] = Carbon::parse($fullTime)->format('Y-m-d H:i:s');
        
        // Generate collision-safe ID
        $validated['appointment_id'] = 'APT-' . uniqid();
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
        // For rescheduling or status updates
        $validated = $request->validate([
            'status' => 'sometimes|in:scheduled,completed,cancelled,no-show',
            'appointment_date' => 'sometimes|date',
            'appointment_time' => 'sometimes', // check format if needed
            'notes' => 'nullable|string'
        ]);
        
        if (isset($validated['appointment_date']) && isset($validated['appointment_time'])) {
            // Check conflicts again if rescheduling
            // This is a simplified check; idealy logic should be shared
            $fullTime = $validated['appointment_date'] . ' ' . $validated['appointment_time'];
             // ... conflict logic here ...
             $validated['appointment_time'] = Carbon::parse($fullTime)->format('Y-m-d H:i:s');
        }

        $appointment->update($validated);

        return redirect()->back()->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->update(['status' => 'cancelled']);
        
        // Check waiting list
        $waiting = WaitingList::where('doctor_id', $appointment->doctor_id)
            ->where('status', 'pending')
            ->where(function($q) use ($appointment) {
                $q->whereNull('preferred_date')
                  ->orWhere('preferred_date', $appointment->appointment_date);
            })
            ->first();
            
        $msg = 'Appointment cancelled.';
        if ($waiting) {
            $waiting->update(['status' => 'notified']);
            $msg .= " Slot opened! Notified waiting patient: {$waiting->patient->name}.";
        }

        return redirect()->route('appointments.index')->with('success', $msg);
    }

    /**
     * API Method to check availability
     */
    public function checkAvailability(Request $request)
    {
        $date = $request->get('date');
        $doctorId = $request->get('doctor_id');

        if (!$date || !$doctorId) {
            return response()->json(['error' => 'Missing date or doctor'], 400);
        }

        // Assume 09:00 to 17:00
        $start = Carbon::parse($date . ' 09:00:00');
        $end = Carbon::parse($date . ' 17:00:00');
        $interval = 30; // minutes

        $bookedSlots = Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_date', $date)
            ->whereNotIn('status', ['cancelled', 'no-show'])
            ->pluck('appointment_time') // This fetches DateTime objects or strings
            ->map(function ($time) {
                return Carbon::parse($time)->format('H:i');
            })
            ->toArray();

        $slots = [];
        $current = $start->copy();

        while ($current->lt($end)) {
            $timeStr = $current->format('H:i');
            $status = in_array($timeStr, $bookedSlots) ? 'booked' : 'available';
            
            $slots[] = [
                'time' => $timeStr,
                'status' => $status
            ];
            
            $current->addMinutes($interval);
        }

        return response()->json(['slots' => $slots]);
    }
}
