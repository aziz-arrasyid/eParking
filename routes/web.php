<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\dashboardAdminController;
use App\Http\Controllers\dashboardJukirController;
use App\Http\Controllers\JukirController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\ParkirController;
use App\Http\Controllers\TransportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [loginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/authenticate', [loginController::class,'authenticate'])->name('authenticate');

Route::middleware(['auth', 'user-role:admin'])->prefix('dashboard-admin')->group(function() {
    Route::get('/', [dashboardAdminController::class, 'index'])->name('admin');
    Route::get('/logout', [logoutController::class, 'logout'])->name('logout');
    Route::resource('data-jukir', JukirController::class);
    Route::get('/server', [dashboardAdminController::class, 'serverSide'])->name('server.side');
    Route::resource('data-kendaraan', TransportController::class);
});

Route::middleware(['auth', 'user-role:jukir'])->prefix('dashboard-jukir')->group(function() {
    Route::get('/', [dashboardJukirController::class, 'index'])->name('jukir');
    Route::resource('data-parkir', ParkirController::class);
    Route::get('/logout', [logoutController::class, 'logout'])->name('logout');
});
