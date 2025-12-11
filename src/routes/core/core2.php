
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CORE\CORE2Controller;

Route::prefix('core/core2')->name('core.core2.')->group(function () {
    // Main index
    Route::get('/', [CORE2Controller::class, 'index'])->name('index');
    // Nested routes
    Route::get('/policies', [CORE2Controller::class, 'policies'])->name('policies');
    Route::get('/reports', [CORE2Controller::class, 'reports'])->name('reports');
});
