<?php

namespace App\Http\Controllers\core1;

use App\Http\Controllers\Controller;
use App\Models\core1\Patient;
use Illuminate\Http\Request;

class PatientManagementController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->get('search', '');
        $statusFilter = $request->get('status', '');
        
        $query = Patient::query();
        
        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('patient_id', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }
        
        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }
        
        $patients = $query->latest()->paginate(15);
        
        // Statistics
        $stats = [
            'total' => Patient::count(),
            'active' => Patient::where('status', 'active')->count(),
            'new_today' => Patient::whereDate('created_at', today())->count(),
            'new_this_month' => Patient::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];
        
        return view('core1.patients.index', compact('patients', 'searchTerm', 'statusFilter', 'stats'));
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

        // Normalize gender to lowercase
        $validated['gender'] = strtolower($validated['gender']);
        
        $validated['patient_id'] = 'HMS-' . date('Y') . '-' . str_pad(Patient::count() + 1, 5, '0', STR_PAD_LEFT);
        $validated['status'] = 'active';
        $validated['last_visit'] = now();

        Patient::create($validated);

        return redirect()->route('patients.index')->with('success', 'Patient registered successfully.');
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

        // Normalize gender to lowercase
        $validated['gender'] = strtolower($validated['gender']);

        $patient->update($validated);

        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }
}

