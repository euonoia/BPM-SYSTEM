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
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('hr2')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('hr.dashboard');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

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
// Route::resource('patients', PatientController::class);
