<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\hr1\EvaluationCriterion_hr1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function questionSets()
    {
        $questionSets = DB::table('question_sets_hr1')
            ->leftJoin('questions_hr1', 'question_sets_hr1.id', '=', 'questions_hr1.question_set_id')
            ->select('question_sets_hr1.*')
            ->groupBy('question_sets_hr1.id')
            ->get()
            ->map(function($qs) {
                $qs->questions = DB::table('questions_hr1')->where('question_set_id', $qs->id)->get();
                return $qs;
            });
        return response()->json($questionSets);
    }

    public function storeQuestionSet(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'sometimes|in:assessment,evaluation,survey,interview',
        ]);

        $questionSet = DB::table('question_sets_hr1')->insertGetId([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'type' => $validated['type'] ?? 'assessment',
            'is_active' => true,
            'created_by' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $questionSetData = DB::table('question_sets_hr1')->where('id', $questionSet)->first();
        $questionSetData->questions = [];
        
        return response()->json($questionSetData, 201);
    }

    public function updateQuestionSet(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'type' => 'sometimes|in:assessment,evaluation,survey,interview',
            'is_active' => 'sometimes|boolean',
        ]);

        DB::table('question_sets_hr1')
            ->where('id', $id)
            ->update(array_merge($validated, ['updated_at' => now()]));

        $questionSet = DB::table('question_sets_hr1')->where('id', $id)->first();
        $questionSet->questions = DB::table('questions_hr1')->where('question_set_id', $id)->get();
        
        return response()->json($questionSet);
    }

    public function destroyQuestionSet($id)
    {
        DB::table('question_sets_hr1')->where('id', $id)->delete();
        return response()->json(['message' => 'Question set deleted successfully']);
    }
}

