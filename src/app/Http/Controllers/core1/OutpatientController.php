<?php

namespace App\Http\Controllers\core1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OutpatientController extends Controller
{
    public function index()
    {
        return view('core1.outpatient.index');
    }
}

