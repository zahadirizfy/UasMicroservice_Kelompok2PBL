<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Gateway\UserGatewayController;



Route::get('/', function () {
    return view('welcome');
});

// API Gateway routes (orchestration & proxy)
use App\Http\Controllers\ApiGatewayController;

Route::prefix('api')->group(function () {
    Route::get('users/{id}', [ApiGatewayController::class, 'getUser']);
    Route::get('clubs/{id}', [ApiGatewayController::class, 'getClub']);
    Route::get('orchestrate/{userId}/{clubId}', [ApiGatewayController::class, 'orchestrate']);
    Route::post('/users', [UserGatewayController::class, 'store']);

});



