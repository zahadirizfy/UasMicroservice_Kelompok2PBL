<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClubApiController;

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
    
    // Club CRUD Endpoints
    Route::apiResource('clubs', ClubApiController::class);
    
    // Health Check
    Route::get('/health', function () {
        return response()->json([
            'status' => 'ok',
            'service' => 'club-service',
            'timestamp' => now()->toISOString(),
        ]);
    });
});

