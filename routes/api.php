<?php

use App\Http\Controllers\Admin\AdminAuthenticationController;
use App\Http\Controllers\Admin\AdminScoreboardController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\ScoreboardController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('send-otp', [OtpController::class, 'store']);

Route::post('login', [AuthenticationController::class, 'login']);
Route::post('verify-phone', [AuthenticationController::class, 'verifyPhone'])->middleware('auth:sanctum');

Route::get('profile', [UserController::class, 'getProfile'])->middleware('auth:sanctum');

Route::get('scoreboard', [ScoreboardController::class, 'index']);


Route::post('admin-login', [AdminAuthenticationController::class, 'login']);
Route::prefix('admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {

    Route::get('customers', [CustomerController::class, 'index']);
    Route::get('customers/{username}', [CustomerController::class, 'show']);

    Route::get('game-records', [AdminScoreboardController::class, 'index']);

});
