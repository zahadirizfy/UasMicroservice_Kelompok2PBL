<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClubController;

/*
|--------------------------------------------------------------------------
| API Routes - Club Service
|--------------------------------------------------------------------------
|
| Semua route di file ini akan diakses dengan prefix /api
| Contoh: GET /api/clubs, POST /api/clubs, dll.
|
*/

// ===========================
// CLUB CRUD ROUTES
// ===========================
Route::prefix('clubs')->group(function () {
    // GET /api/clubs - List semua clubs
    Route::get('/', [ClubController::class, 'index']);
    
    // POST /api/clubs - Create club baru
    Route::post('/', [ClubController::class, 'store']);
    
    // GET /api/clubs/{id} - Get detail club
    Route::get('/{id}', [ClubController::class, 'show']);
    
    // PUT /api/clubs/{id} - Update club
    Route::put('/{id}', [ClubController::class, 'update']);
    
    // DELETE /api/clubs/{id} - Delete club
    Route::delete('/{id}', [ClubController::class, 'destroy']);
});

// ===========================
// HEALTH CHECK
// ===========================
Route::get('/health', function () {
    return response()->json([
        'service' => 'Club Service',
        'status' => 'healthy',
        'timestamp' => now()->toISOString()
    ]);
});

