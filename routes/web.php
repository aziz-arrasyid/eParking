<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\dashboardAdminController;
use App\Http\Controllers\logoutController;

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
});
