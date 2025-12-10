<?php

use App\Http\Controllers\GameGuardController;
use Illuminate\Support\Facades\Route;


Route::post('verify-token',[GameGuardController::class,'verifyToken'])->middleware('auth:sanctum');

Route::post('submit-score',[GameGuardController::class,'submitScore'])->middleware('auth:sanctum');
