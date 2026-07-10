<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\RiskController;
use App\Http\Controllers\Api\PortController;
use App\Http\Controllers\Api\WeatherController;

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
Route::get('/risk/leaderboard', [RiskController::class, 'leaderboard']);

// Weather
Route::get('/weather', [WeatherController::class, 'index']);
Route::get('/weather/all', [WeatherController::class, 'all']);
Route::get('/weather/forecast', [WeatherController::class, 'forecast']);

// Ports
Route::get('/ports', [PortController::class, 'index']);

// Leaderboard
Route::get('/risk/leaderboard', [RiskController::class, 'leaderboard']);

// News
Route::get('/news', [\App\Http\Controllers\Api\NewsController::class, 'index']);

// Currency
Route::get('/currency', [\App\Http\Controllers\Api\CurrencyController::class, 'index']);
Route::get('/currency/trend', [\App\Http\Controllers\Api\CurrencyController::class, 'trend']);
