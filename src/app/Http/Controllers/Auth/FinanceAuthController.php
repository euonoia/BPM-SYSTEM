<?php
namespace App\Http\Controllers\Auth;

class FinanceAuthController extends BaseAuthController
{
    protected string $guard = 'finance';

    protected function redirectAfterLogin()
    {
        return redirect()->route('finance.dashboard');
    }
}
