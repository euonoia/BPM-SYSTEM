<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // Route model binding for core1 Patient model
            // This ensures the correct Patient model is used for core1 routes
            \Illuminate\Support\Facades\Route::bind('patient', function ($value) {
                // Try numeric ID first (most common)
                if (is_numeric($value)) {
                    $patient = \App\Models\core1\Patient::find($value);
                    if ($patient) {
                        return $patient;
                    }
                }
                // Fallback: try patient_id if not found by numeric ID
                return \App\Models\core1\Patient::where('patient_id', $value)->firstOrFail();
            });
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            '/logout',
            '/portal/logout',
        ]);

        $middleware->alias([
            'role' => \App\Http\Middleware\Core1RoleMiddleware::class,
            'multiAuth' => \App\Http\Middleware\MultiAuthMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
