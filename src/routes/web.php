<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeAuthController;
use App\Http\Controllers\CoreAuthController;


/*
|--------------------------------------------------------------------------
| Homepage (Public / Core)
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('index'));
/*
|--------------------------------------------------------------------------
| Employee Portal
|--------------------------------------------------------------------------
*/
Route::prefix('portal')->group(function () {
    Route::get('/', [EmployeeAuthController::class, 'showLogin'])->name('portal.login');
    Route::post('/login', [EmployeeAuthController::class, 'login'])->name('portal.login.submit');
    Route::post('/logout', [EmployeeAuthController::class, 'logout'])->name('portal.logout');
});

/*
|--------------------------------------------------------------------------
| Core Authentication
|--------------------------------------------------------------------------
*/
Route::get('/login', [CoreAuthController::class, 'showLogin'])->name('core.login');
Route::post('/login', [CoreAuthController::class, 'login'])->name('core.login.post');
Route::get('/register', [CoreAuthController::class, 'register'])->name('core.register');
Route::post('/register', [CoreAuthController::class, 'register'])->name('core.register.post');
Route::post('/logout', [CoreAuthController::class, 'logout'])->name('core.logout');
/*

/*
|--------------------------------------------------------------------------
| Core Post-Login Router
|--------------------------------------------------------------------------
*/
Route::middleware('auth:core')->get('/core', function () {
    $user = auth('core')->user();

    return match ($user->role) {
        'admin'         => redirect()->route('admin.dashboard'),
        'doctor'        => redirect()->route('doctor.dashboard'),
        'nurse'         => redirect()->route('nurse.dashboard'),
        'patient'       => redirect()->route('patient.dashboard'),
        'receptionist'  => redirect()->route('receptionist.dashboard'),
        'billing'       => redirect()->route('billing.dashboard'),
        default         => abort(403),
    };
})->name('core.home');

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
