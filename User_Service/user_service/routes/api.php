<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes - User Service
|--------------------------------------------------------------------------
| Semua endpoint di sini STATELESS (Sanctum token), tanpa session.
|--------------------------------------------------------------------------
*/

Route::middleware(['correlation.id'])->group(function () {

    // =========================
    // AUTH (TOKEN - STATELESS)
    // =========================
    Route::prefix('auth')->group(function () {

        // Public
        Route::post('/register', [AuthController::class, 'apiRegister']);
        Route::post('/login', [AuthController::class, 'apiLogin']);

        // Protected (butuh Bearer token)
        Route::middleware('auth:sanctum')->group(function () {

            // ✅ Endpoint standar "ME"
            Route::get('/me', [AuthController::class, 'apiProfile']);

            // Optional: tetap sediakan /profile juga (kalau dipakai di laporan)
            Route::get('/profile', [AuthController::class, 'apiProfile']);

            Route::post('/logout', [AuthController::class, 'apiLogout']);
        });
    });

    // =========================
    // USER CRUD
    // =========================
    // Kalau mau protected, bungkus dengan Route::middleware('auth:sanctum')->group(...)
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);

    // =========================
    // HEALTH CHECK
    // =========================
    Route::get('/health', function () {
        return response()->json([
            'status' => 'ok',
            'service' => 'user-service',
            'timestamp' => now()->toISOString(),
        ]);
    });
});
