<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\hr1\EvaluationCriterion_hr1;
use Illuminate\Http\Request;

class EvaluationController_hr1 extends Controller
{
    public function index()
    {
        $criteria = EvaluationCriterion_hr1::all();
        return response()->json($criteria);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'section' => 'required|in:A,B,C',
            'weight' => 'required|integer|min:1|max:100',
        ]);

        $criterion = EvaluationCriterion_hr1::create($validated);
        return response()->json($criterion, 201);
    }

    public function destroy($id)
    {
        $criterion = EvaluationCriterion_hr1::findOrFail($id);
        $criterion->delete();
        return response()->json(['message' => 'Criterion deleted successfully']);
    }
}

