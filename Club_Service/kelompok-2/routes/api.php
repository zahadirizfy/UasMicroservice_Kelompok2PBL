<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClubController;

/*
|--------------------------------------------------------------------------
| API Routes - Club Service
|--------------------------------------------------------------------------
|
| Endpoint API untuk Club Service yang akan digunakan oleh Gateway.
| Semua route sudah dilengkapi dengan Correlation ID middleware.
|
*/

Route::prefix('v1')->middleware(['correlation.id'])->group(function () {
    
    // Club CRUD Endpoints (menggunakan ClubController yang sudah ada)
    Route::get('clubs', [ClubController::class, 'apiIndex']);
    Route::post('clubs', [ClubController::class, 'apiStore']);
    Route::get('clubs/{id}', [ClubController::class, 'apiShow']);
    Route::put('clubs/{id}', [ClubController::class, 'apiUpdate']);
    Route::delete('clubs/{id}', [ClubController::class, 'apiDestroy']);
    
    // Health Check
    Route::get('/health', function () {
        return response()->json([
            'status' => 'ok',
            'service' => 'club-service',
            'timestamp' => now()->toISOString(),
        ]);
    });
});


