<?php

namespace App\Http\Controllers\core1;

use App\Http\Controllers\Controller;
use App\Models\core1\Patient;
use App\Models\core1\User;
use Illuminate\Http\Request;

class PatientManagementController extends Controller
{
    public function index(Request $request)
{
    $searchTerm = $request->get('search', '');
    $statusFilter = $request->get('status', '');

    $user = auth()->user();
    $isDoctor = $user->role === 'doctor';

    // Base query
    $query = Patient::query();

    if ($isDoctor) {
        // Doctor sees only their scheduled patients (already correct)
        $query->whereHas('appointments', function ($q) use ($user) {
            $q->where('doctor_id', $user->id)
              ->where('status', 'scheduled');
        });
    } else {
        // Admin/Receptionist: show only patients with scheduled appointments
        $query->whereHas('appointments', function ($q) {
            $q->where('status', 'scheduled');
        });
    }

    // SEARCH
    if ($searchTerm) {
        $query->where(function ($q) use ($searchTerm) {
            $q->where('name', 'like', "%{$searchTerm}%")
              ->orWhere('patient_id', 'like', "%{$searchTerm}%")
              ->orWhere('email', 'like', "%{$searchTerm}%");
        });
    }

    // STATUS FILTER
    if ($statusFilter) {
        $query->where('status', $statusFilter);
    }

    $patients = $query->latest()->paginate(15);

    // STATISTICS
    if ($isDoctor) {
        $patientIds = Patient::whereHas('appointments', function ($q) use ($user) {
            $q->where('doctor_id', $user->id)
              ->where('status', 'scheduled');
        })->pluck('id');

        $stats = [
            'total' => $patientIds->count(),
            'active' => Patient::whereIn('id', $patientIds)
                ->where('status', 'active')
                ->count(),
            'new_today' => Patient::whereIn('id', $patientIds)
                ->whereDate('created_at', today())
                ->count(),
            'new_this_month' => Patient::whereIn('id', $patientIds)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];
<<<<<<< Updated upstream
        
        // Nurses for assignment (Head Nurse/Admin only)
        $nurses = [];
        if (auth()->user()->isAdmin() || auth()->user()->isHeadNurse()) {
            $nurses = User::where('role', 'nurse')->get();
        }
        
        return view('core1.patients.index', compact('patients', 'searchTerm', 'statusFilter', 'stats', 'nurses'));
=======
    } else {
        // Admin/Receptionist stats for patients with scheduled appointments only
        $patientIds = Patient::whereHas('appointments', function ($q) {
            $q->where('status', 'scheduled');
        })->pluck('id');

        $stats = [
            'total' => $patientIds->count(),
            'active' => Patient::whereIn('id', $patientIds)
                ->where('status', 'active')
                ->count(),
            'new_today' => Patient::whereIn('id', $patientIds)
                ->whereDate('created_at', today())
                ->count(),
            'new_this_month' => Patient::whereIn('id', $patientIds)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];
    }

    return view('core1.patients.index', compact(
        'patients',
        'searchTerm',
        'statusFilter',
        'stats'
    ));
}


    public function move(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'care_type' => 'required|in:inpatient,outpatient',
            'admission_date' => 'required|date',
            'doctor_id' => 'required|exists:users_core1,id',
            'reason' => 'nullable|string',
        ]);

        $patient->update($data);

        return $data['care_type'] === 'inpatient'
            ? redirect()->route('inpatient.index')->with('success', 'Patient admitted successfully.')
            : redirect()->route('outpatient.index')->with('success', 'Patient moved to outpatient care.');
    }

    /**
     * ✅ ADDED — Outpatient Status Update (FUNCTIONAL)
     * scheduled | waiting | in consultation | consulted
     */
    public function updateStatus(Request $request, Patient $patient)
    {
        $request->validate([
            'status' => 'required|in:scheduled,waiting,in consultation,consulted'
        ]);

        $patient->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status updated.');
>>>>>>> Stashed changes
    }

    public function create()
    {
        return view('core1.patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other,Male,Female,Other',
            'phone' => 'required|string',
            'email' => 'required|email|unique:patients_core1,email',
            'address' => 'nullable|string',
        ]);

        $validated['gender'] = strtolower($validated['gender']);

        $year = date('Y');

        $lastNumber = Patient::where('patient_id', 'like', "HMS-{$year}-%")
            ->selectRaw("MAX(CAST(SUBSTRING(patient_id, 10, 5) AS UNSIGNED)) as max_num")
            ->value('max_num');

        $nextNumber = $lastNumber ? $lastNumber + 1 : 1;

        $validated['patient_id'] = 'HMS-' . $year . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        $validated['status'] = 'active';
        $validated['last_visit'] = now();

        Patient::create($validated);

        return redirect()->route('core1.patients.index')->with('success', 'Patient registered successfully.');
    }

    public function show(Patient $patient)
    {
        return view('core1.patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('core1.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other,Male,Female,Other',
            'phone' => 'required|string',
            'email' => 'required|email|unique:patients_core1,email,' . $patient->id,
            'address' => 'nullable|string',
        ]);

        $validated['gender'] = strtolower($validated['gender']);

        $patient->update($validated);

        return redirect()->route('core1.patients.index')->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('core1.patients.index')->with('success', 'Patient deleted successfully.');
    }

    public function assignNurse(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'nurse_id' => 'required|exists:users_core1,id',
        ]);

        $patient->update([
            'assigned_nurse_id' => $validated['nurse_id']
        ]);

        return back()->with('success', 'Nurse assigned to patient successfully.');
    }
}
