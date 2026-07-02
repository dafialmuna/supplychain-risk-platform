<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\RiskController;
use App\Http\Controllers\Api\PortController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Route test
Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});

// Countries
Route::get('/countries', [CountryController::class, 'index']);

// Risk
Route::get('/risk', [RiskController::class, 'index']);

// Ports
Route::get('/ports', [PortController::class, 'index']);

Route::get('/risk/leaderboard', [RiskController::class, 'leaderboard']);
