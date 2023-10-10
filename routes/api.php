<?php

use App\Http\Controllers\Api\ParkirController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboardJukirController;
use App\Http\Controllers\handlePaymentNotif;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/midtrans-callback-unfinish', [dashboardJukirController::class, 'callbackUnfinish'])->name('callback');

Route::post('midtrans/notif-hook', ParkirController::class);
Route::get('midtrans/notif-hook-get', ParkirController::class);

Route::post('/authenticate', [loginController::class,'authenticate'])->name('authenticate');

