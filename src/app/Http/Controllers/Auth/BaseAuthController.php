<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

abstract class BaseAuthController extends Controller
{
    protected string $guard;

    protected function loginUser(Request $request, array $credentials)
    {
        if (!Auth::guard($this->guard)->attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }

        $request->session()->regenerate();

        return $this->redirectAfterLogin();
    }

    abstract protected function redirectAfterLogin();
}
