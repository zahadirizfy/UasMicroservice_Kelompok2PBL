<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// (Opsional) halaman root
Route::get('/', function () {
    return response()->json([
        'service' => 'user-service',
        'status'  => 'ok'
    ]);
});

// WEB login (session-based) — dipakai kalau kamu memang punya view login/dashboard
Route::get('/login', [AuthController::class, 'login'])->name('login');                 // tampil halaman login (view)
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.process'); // proses login web (session)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');             // logout web (session)
