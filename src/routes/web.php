<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;

// Homepage
Route::get('/', fn () => view('index'));

/*
|--------------------------------------------------------------------------
| Modular Route Loading
|--------------------------------------------------------------------------
| Dynamically loads all route files from modules (nested or flat) 
| recursively to ensure all routes are instantly available.
*/

// Helper function to recursively load all PHP files in a directory
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
