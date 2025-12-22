<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\ScoreboardController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('send-otp', [OtpController::class,'store']);

Route::post('login',[AuthenticationController::class,'login']);
Route::post('verify-phone',[AuthenticationController::class,'verifyPhone'])->middleware('auth:sanctum');

Route::get('profile',[UserController::class,'getProfile'])->middleware('auth:sanctum');

Route::get('scoreboard', [ScoreboardController::class, 'index']);
