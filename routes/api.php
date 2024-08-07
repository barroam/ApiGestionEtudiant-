<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\AuthJwtController;
use App\Http\Controllers\MatiereController;


Route::post('register', [AuthJwtController::class, 'register']);
Route::post('login', [AuthJwtController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    Route::post('refresh', [AuthJwtController::class, 'refresh']);
    Route::post('blacklist', [AuthJwtController::class, 'blacklist']);
    Route::post('logout', [AuthJwtController::class, 'logout']);
    Route::get('get-token/{user_id}', [AuthJwtController::class, 'getTokenByUser']);
 /*   Route::post('storeEtudiant', [EleveController::class, 'storeEtudiant']);
    Route::post('storeEtudiant', [EleveController::class, 'storeEtudiant']);
    Route::post('indexEtudiant', [EleveController::class, 'indexEtudiant']);*/
});
/*
Route::controller(ApiController::class)->middleware('auth:api')->group(function () {
    Route::get('private-endpoint', 'privateEndopint');
});*/

Route::middleware('auth:api')->apiResource('eleve', EleveController::class);
Route::middleware('auth:api')->apiResource('matiere', MatiereController::class);



