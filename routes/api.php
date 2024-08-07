<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthJwtController;


Route::post('register', [AuthJwtController::class, 'register']);
Route::post('login', [AuthJwtController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::post('refresh', [AuthJwtController::class, 'refresh']);
    Route::post('blacklist', [AuthJwtController::class, 'blacklist']);
    Route::post('logout', [AuthJwtController::class, 'logout']);
    Route::get('get-token/{user_id}', [AuthJwtController::class, 'getTokenByUser']);
  });
/*
Route::controller(ApiController::class)->middleware('auth:api')->group(function () {
    Route::get('private-endpoint', 'privateEndopint');
});*/

