<?php

namespace App\Http\Controllers\Hr2;

use App\Http\Controllers\Controller;
use App\Models\hr2\Competency;

class CompetencyController extends Controller
{
    public function index()
    {
        $competencies = Competency::orderBy('created_at', 'desc')->get();
        return view('hr2.competencies', compact('competencies'));
    }
}
