<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware(['correlation.id'])->group(function () {

    // GET semua user
    Route::get('/users', [UserController::class, 'index']);

    // GET user by id
    Route::get('/users/{id}', [UserController::class, 'show']);

    // ✅ TAMBAH INI (POST USER)
    Route::post('/users', [UserController::class, 'store']);

    
});
