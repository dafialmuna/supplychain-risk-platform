<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PortController;
use App\Http\Controllers\Admin\ArticleController;

// ========== HALAMAN UTAMA ==========
Route::get('/', function () {
    return view('dashboard.index'); // Arahkan ke dashboard utama kita
})->name('home');

// ========== TRACKING CARGO ==========
Route::get('/tracking', [\App\Http\Controllers\TrackingController::class, 'index'])->name('tracking.index');
Route::post('/tracking', [\App\Http\Controllers\TrackingController::class, 'search'])->name('tracking.search');

// ========== HALAMAN DASHBOARD ==========
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/weather', [\App\Http\Controllers\DashboardController::class, 'weather'])->name('dashboard.weather');
    Route::get('/currency', [\App\Http\Controllers\DashboardController::class, 'currency'])->name('dashboard.currency');
    Route::get('/news', [\App\Http\Controllers\DashboardController::class, 'news'])->name('dashboard.news');
    Route::get('/ports', [\App\Http\Controllers\DashboardController::class, 'ports'])->name('dashboard.ports');
    Route::get('/visualization', [\App\Http\Controllers\DashboardController::class, 'visualization'])->name('dashboard.visualization');
    Route::get('/compare', [\App\Http\Controllers\DashboardController::class, 'compare'])->name('dashboard.compare');
    Route::get('/routing', [\App\Http\Controllers\DashboardController::class, 'routing'])->name('dashboard.routing');
});

// ========== HALAMAN PROJECT FINAL ==========
Route::get('/project-final', function () {
    return view('project-final-web');
})->name('project.final');

// ========== PROFILE ==========
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ========== ADMIN ROUTES (Hanya untuk admin) ==========
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('ports', PortController::class);
    Route::resource('articles', ArticleController::class);
    Route::resource('shipments', \App\Http\Controllers\Admin\ShipmentController::class);
    Route::post('shipments/{shipment}/log', [\App\Http\Controllers\Admin\ShipmentController::class, 'addLog'])->name('shipments.addLog');
});

Route::middleware('auth')->group(function () {
    Route::get('/watchlist', [App\Http\Controllers\WatchlistController::class, 'index'])->name('watchlist.index');
    Route::post('/watchlist', [App\Http\Controllers\WatchlistController::class, 'store'])->name('watchlist.store');
    Route::delete('/watchlist/{id}', [App\Http\Controllers\WatchlistController::class, 'destroy'])->name('watchlist.destroy');
    
    // User Shipments
    Route::get('/my-shipments', [\App\Http\Controllers\TrackingController::class, 'myShipments'])->name('tracking.my_shipments');
});
// ========== AUTH ROUTES (Breeze) ==========
require __DIR__.'/auth.php';