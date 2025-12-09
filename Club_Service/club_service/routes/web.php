<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'service' => 'Club Service',
        'version' => '1.0.0',
        'documentation' => '/api/docs'
    ]);
});

