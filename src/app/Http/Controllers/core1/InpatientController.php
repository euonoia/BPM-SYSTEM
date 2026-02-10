<?php

namespace App\Http\Controllers\core1;

use App\Http\Controllers\Controller;
use App\Models\core1\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class InpatientController extends Controller
{
    public function index()
    {
         $user = Auth::user();
        $isDoctor = $user->role === 'doctor';

        // Query inpatients
        $inpatients = Patient::query()
        ->where('care_type', 'inpatient')
        ->when($isDoctor, fn($q) => $q->where('doctor_id', $user->id))
        ->whereHas('appointments', function ($q) use ($user, $isDoctor) {
            $q->where('status', 'scheduled'); // Only show scheduled patients
            if ($isDoctor) {
                $q->where('doctor_id', $user->id);
            }
        })
        ->latest()
        ->get();

        // Stats
        $stats = [
            'current_inpatients' => $inpatients->count(),
            'occupied' => $inpatients->count(), // assuming each inpatient occupies a bed
            'discharges_today' => Patient::where('care_type', 'inpatient')
                                        ->whereDate('last_visit', today())
                                        ->count(),
        ];

        // Beds (temporary placeholders for UI)
        $beds = [];
        for ($i = 1; $i <= 10; $i++) {
            $beds[] = [
                'id' => 'Bed ' . $i,
                'type' => 'General',
                'status' => 'available',
                'bg' => 'core1-bed-available',
                'patient' => '',
                'patient_id' => '',
            ];
        }

        return view('core1.inpatient.index', compact('inpatients', 'stats', 'beds'));
    }

    public function deactivate(Patient $patient)
{
    // Toggle status
    $patient->update([
        'status' => 'inactive',
    ]);

    return back()->with('success', 'Patient status updated to inactive.');
}

}
