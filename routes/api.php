<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ParkirController;
use App\Http\Controllers\Api\JukirControllerApi;
use App\Http\Controllers\Api\MidtransAndroid;
use App\Http\Controllers\Api\ParkirControllerApi;
use App\Http\Controllers\Api\tableController;

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
Route::get('/tableParkir/{id}', [tableController::class,'tableParkir'])->name('tableParkir');
//apiResource jukir CRUD pada android
Route::apiResources([
    'jukir' => JukirControllerApi::class,
    'parkir' => ParkirControllerApi::class,
]);
//api untuk midtrans di mobile
Route::post('/midtrans/pay', [MidtransAndroid::class, 'payment']);
