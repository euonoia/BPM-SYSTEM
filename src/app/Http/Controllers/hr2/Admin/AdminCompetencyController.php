<?php

namespace App\Http\Controllers\Hr2\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hr2\Admin\CompetencyHr2;
use Illuminate\Support\Facades\DB;

class AdminCompetencyController extends Controller
{
    // Show all competencies
    public function index()
    {
        $competencies = CompetencyHr2::orderBy('created_at', 'desc')->get();
        return view('hr2.admin.competencies', compact('competencies'));
    }

    // Add new competency
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'competency_group' => 'nullable|string|max:255',
        ]);

        // Generate next code automatically
        $last = CompetencyHr2::orderBy('id', 'desc')->first();
        $lastNumber = $last ? (int) preg_replace('/\D/', '', $last->code) : 0;
        $nextNumber = $lastNumber + 1;
        $code = 'COMP' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        CompetencyHr2::create([
            'code' => $code,
            'title' => $request->title,
            'description' => $request->description,
            'competency_group' => $request->competency_group,
        ]);

        return redirect()->route('admin.competency')->with('success', 'Competency added.');
    }

    // Archive (soft delete) a competency
    public function destroy($id)
    {
        $competency = CompetencyHr2::findOrFail($id);

        // Move to archive table
        DB::table('competencies_archive_hr2')->insert([
            'code' => $competency->code,
            'title' => $competency->title,
            'description' => $competency->description,
            'competency_group' => $competency->competency_group,
            'created_at' => $competency->created_at,
            'updated_at' => now(),
        ]);

        $competency->delete();

        return redirect()->route('admin.competency')->with('success', 'Competency archived.');
    }
}
