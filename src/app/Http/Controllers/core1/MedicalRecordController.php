<?php

namespace App\Http\Controllers\core1;

use App\Http\Controllers\Controller;
use App\Models\core1\MedicalRecord;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $records = MedicalRecord::with(['patient', 'doctor'])->latest()->paginate(20);
        return view('core1.medical-records.index', compact('records'));
    }

    public function show(MedicalRecord $record)
    {
        $record->load(['patient', 'doctor']);
        return view('core1.medical-records.show', compact('record'));
    }
}

