<?php

use App\Http\Controllers\Api\JukirControllerApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ParkirController;

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
//api unntuk payment gateway website
Route::post('midtrans/notif-hook', ParkirController::class);
//api untuk login pada android
Route::post('/authenticate', [LoginController::class,'authenticate'])->name('authenticate');
//apiResource jukir CRUD pada android
Route::apiResources([
    'jukir' => JukirControllerApi::class,
]);
