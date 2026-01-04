<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

class HrAuthController extends BaseAuthController
{
    protected string $guard = 'hr';

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        return $this->loginUser($request, $request->only('email', 'password'));
    }

    protected function redirectAfterLogin()
    {
        return redirect()->route('hr2.dashboard');
    }
}
