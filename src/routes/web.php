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
    Route::match(['get', 'post'], '/logout', [EmployeeAuthController::class, 'logout'])->name('portal.logout');
});

/*
|--------------------------------------------------------------------------
| Core Authentication
|--------------------------------------------------------------------------
*/
Route::get('/login', [CoreAuthController::class, 'showLogin'])->name('core1.login');
Route::post('/login', [CoreAuthController::class, 'login'])->name('core1.login.post');
Route::get('/register', [CoreAuthController::class, 'showRegistrationForm'])->name('core1.register');
Route::post('/register', [CoreAuthController::class, 'register'])->name('core1.register.post');
Route::match(['get', 'post'], '/logout', [CoreAuthController::class, 'logout'])->name('core1.logout');
/*

/*
|--------------------------------------------------------------------------
| Core Post-Login Router
|--------------------------------------------------------------------------
*/
Route::middleware('auth:core1')->get('/core1', function () {
    $user = auth('core1')->user();

    return match ($user->role) {
        'admin'         => redirect()->route('core1.admin.dashboard'),
        'doctor'        => redirect()->route('core1.doctor.dashboard'),
        'nurse', 'head_nurse' => redirect()->route('core1.nurse.dashboard'),
        'patient'       => redirect()->route('core1.patient.dashboard'),
        'receptionist'  => redirect()->route('core1.receptionist.dashboard'),
        'billing'       => redirect()->route('core1.billing.dashboard'),
        default         => abort(403),
    };
})->name('core1.home');

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
