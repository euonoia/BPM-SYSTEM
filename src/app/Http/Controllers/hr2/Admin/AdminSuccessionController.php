<?php

namespace App\Http\Controllers\Hr2\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hr2\Admin\SuccessionPositionHr2;
use App\Models\hr2\Admin\SuccessorCandidateHr2;
use App\Models\Authenticate;

class AdminSuccessionController extends Controller
{
    public function index()
    {
        $positions = SuccessionPositionHr2::withCount('candidates')->orderBy('position_title')->get();
        $candidates = SuccessorCandidateHr2::with(['position', 'employee'])
            ->orderBy('branch_id')
            ->get();
        $employees = Authenticate::orderBy('first_name')->get();

        return view('hr2.admin.succession', compact('positions', 'candidates', 'employees'));
    }

    public function storePosition(Request $request)
    {
        $request->validate([
            'position_title' => 'required|string|max:255',
            'criticality' => 'required|in:low,medium,high',
        ]);

        $branch_id = 'BR' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));

        SuccessionPositionHr2::create([
            'position_title' => $request->position_title,
            'branch_id' => $branch_id,
            'criticality' => $request->criticality,
        ]);

        return redirect()->route('admin.succession')->with('success', 'Position added.');
    }

    public function storeCandidate(Request $request)
    {
        $request->validate([
            'position_id' => 'required|exists:succession_positions,branch_id',
            'employee_id' => 'required|exists:employees,employee_id',
            'readiness' => 'required|in:ready,not_ready',
            'effective_at' => 'required|date',
            'development_plan' => 'nullable|string',
        ]);

        SuccessorCandidateHr2::create([
            'branch_id' => $request->position_id,
            'employee_id' => $request->employee_id,
            'readiness' => $request->readiness,
            'effective_at' => $request->effective_at,
            'development_plan' => $request->development_plan,
        ]);

        return redirect()->route('admin.succession')->with('success', 'Candidate added.');
    }

    public function destroyPosition($id)
    {
        $position = SuccessionPositionHr2::findOrFail($id);
        // Archive logic can be implemented here
        $position->delete();

        return redirect()->route('admin.succession')->with('success', 'Position archived.');
    }

    public function destroyCandidate($id)
    {
        $candidate = SuccessorCandidateHr2::findOrFail($id);
        // Archive logic can be implemented here
        $candidate->delete();

        return redirect()->route('admin.succession')->with('success', 'Candidate archived.');
    }
}
