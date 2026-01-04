<?php
namespace App\Http\Controllers\Auth;

class LogisticsAuthController extends BaseAuthController
{
    protected string $guard = 'logistics';

    protected function redirectAfterLogin()
    {
        return redirect()->route('logistics.dashboard');
    }
}
