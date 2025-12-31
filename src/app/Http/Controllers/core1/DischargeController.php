<?php

namespace App\Http\Controllers\core1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DischargeController extends Controller
{
    public function index()
    {
        return view('core1.discharge.index');
    }
}

