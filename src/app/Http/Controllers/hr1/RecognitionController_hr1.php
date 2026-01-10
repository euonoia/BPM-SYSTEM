<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\hr1\Recognition_hr1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecognitionController_hr1 extends Controller
{
    public function index()
    {
        $recognitions = Recognition_hr1::latest()->get();
        return response()->json($recognitions);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'to' => 'required|string|max:255',
            'reason' => 'required|string',
            'award_type' => 'required|string|max:255',
        ]);

        $recognition = Recognition_hr1::create([
            'from' => Auth::user()->name ?? 'System',
            'to' => $validated['to'],
            'reason' => $validated['reason'],
            'award_type' => $validated['award_type'],
            'date' => now(),
            'congratulations' => 0,
            'boosts' => 0,
        ]);

        return response()->json($recognition, 201);
    }

    public function congratulate($id)
    {
        $recognition = Recognition_hr1::findOrFail($id);
        $recognition->increment('congratulations');
        return response()->json($recognition);
    }

    public function boost($id)
    {
        $recognition = Recognition_hr1::findOrFail($id);
        $recognition->increment('boosts');
        return response()->json($recognition);
    }

    public function destroy($id)
    {
        $recognition = Recognition_hr1::findOrFail($id);
        $recognition->delete();
        return response()->json(['message' => 'Recognition deleted successfully']);
    }
}

