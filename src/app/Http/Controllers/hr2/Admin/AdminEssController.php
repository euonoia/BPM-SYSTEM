<?php

namespace App\Http\Controllers\Hr2\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hr2\Admin\EssRequestHr2;

class AdminEssController extends Controller
{
    public function index()
    {
        $requests = EssRequestHr2::with('employee')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('hr2.admin.ess', compact('requests'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,closed',
        ]);

        $ess = EssRequestHr2::findOrFail($id);
        $ess->status = $request->status;
        $ess->save();

        // Archive if approved or rejected
        if (in_array($request->status, ['approved', 'rejected'])) {
            $ess->archive();
        }

        return redirect()->route('admin.ess')->with('success', 'Request status updated.');
    }
}
