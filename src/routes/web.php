<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\hr2\DashboardController;

/*
|--------------------------------------------------------------------------
| Homepage
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('index'));

/*
|--------------------------------------------------------------------------
| Debug Routes (Remove after testing)
|--------------------------------------------------------------------------
*/
Route::get('/debug/employee-login', function () {
    $emp = \App\Models\Employee::first();
    return [
        'email' => $emp->email,
        'has_password' => !empty($emp->password),
    ];
});

Route::get('/debug/auth-status', function () {
    return [
        'admin_authenticated' => auth('admin')->check(),
        'user_authenticated' => auth('user')->check(),
        'admin_user' => auth('admin')->check() ? auth('admin')->user()->email : null,
        'user_user' => auth('user')->check() ? auth('user')->user()->email : null,
    ];
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('hr2')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('hr.dashboard');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Admin authentication (separate)
use App\Http\Controllers\Auth\AdminAuthController;
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// User/Employee authentication (separate)
use App\Http\Controllers\Auth\UserAuthController;
Route::get('/user/login', [UserAuthController::class, 'showLogin'])->name('user.login');
Route::post('/user/login', [UserAuthController::class, 'login'])->name('user.login.post');
Route::post('/user/logout', [UserAuthController::class, 'logout'])->name('user.logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Modular Route Loading (ARTISAN-SAFE)
|--------------------------------------------------------------------------
*/

if (!function_exists('loadModuleRoutes')) {
    function loadModuleRoutes(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                require_once $file->getPathname();
            }
        }
    }
}

// List of all modules
$modules = ['core', 'hr', 'logistics', 'landing', 'financials'];

foreach ($modules as $module) {
    loadModuleRoutes(__DIR__ . '/' . $module);
}

/*
|--------------------------------------------------------------------------
| Resource Routes
|--------------------------------------------------------------------------
*/
Route::resource('patients', PatientController::class);
