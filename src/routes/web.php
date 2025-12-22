<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\hr2\DashboardController;


// Homepage
Route::get('/', fn () => view('index'));

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
| Routes for login, logout, and dashboard redirection based on roles
*/
Route::middleware('auth')->prefix('hr2')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('hr.dashboard');
});
// Show login form
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
// Process login form
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
// Registration
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Optional: dashboard landing (redirect by role if needed)
Route::middleware('auth')->group(function () {
    Route::get('/admin', fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/core', fn() => view('core1.index'))->name('core.dashboard');
    Route::get('/logistics', fn() => view('logistics.dashboard'))->name('logistics.dashboard');
    Route::get('/financials', fn() => view('financials.dashboard'))->name('financials.dashboard');
});

/*
|--------------------------------------------------------------------------
| Modular Route Loading
|--------------------------------------------------------------------------
| Dynamically loads all route files from modules (nested or flat) 
| recursively to ensure all routes are instantly available.
*/

function loadModuleRoutes(string $dir)
{
    if (!is_dir($dir)) return;

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir)
    );

    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            require $file->getPathname();
        }
    }
}

// List of all modules
$modules = ['core', 'hr', 'logistics', 'landing', 'financials'];

foreach ($modules as $module) {
    loadModuleRoutes(__DIR__ . '/' . $module);
}

// Resource routes
Route::resource('patients', PatientController::class);
