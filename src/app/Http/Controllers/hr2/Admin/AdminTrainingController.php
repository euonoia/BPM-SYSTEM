<?php

namespace App\Http\Controllers\Hr2\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hr2\Admin\TrainingSessionHr2;

class AdminTrainingController extends Controller
{
    public function index()
    {
        $sessions = TrainingSessionHr2::withCount('enrolls')
            ->orderBy('start_datetime', 'desc')
            ->get();

        return view('hr2.admin.training', compact('sessions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_datetime' => 'required|date',
            'end_datetime' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'trainer' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:1',
        ]);

        // Generate unique training ID
        $last = TrainingSessionHr2::orderBy('id', 'desc')->first();
        $num = $last ? (int)filter_var($last->training_id, FILTER_SANITIZE_NUMBER_INT) + 1 : 1;
        $training_id = 'TRN-' . str_pad($num, 4, '0', STR_PAD_LEFT);

        TrainingSessionHr2::create(array_merge($request->all(), [
            'training_id' => $training_id
        ]));

        return redirect()->route('admin.training')->with('success', 'Training session added.');
    }

    public function destroy($id)
    {
        $session = TrainingSessionHr2::findOrFail($id);

        // Archive logic can be added here if needed
        $session->delete();

        return redirect()->route('admin.training')->with('success', 'Training session archived.');
    }
}
