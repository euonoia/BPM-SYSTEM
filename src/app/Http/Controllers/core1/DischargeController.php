<?php

namespace App\Http\Controllers\core1;

use Illuminate\Http\Request;

class DischargeController extends Controller
{
    public function index()
    {
        return view('core1.discharge.index');
    }
}

