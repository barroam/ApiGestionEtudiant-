<?php

use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UeController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\AuthJwtController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\EvaluationController;


Route::post('register', [AuthJwtController::class, 'register']);
Route::post('login', [AuthJwtController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    Route::post('refresh', [AuthJwtController::class, 'refresh']);
    Route::post('logout', [AuthJwtController::class, 'logout']);
    Route::post('eleves-restore/{id}', [EleveController::class, 'restore']);
});


Route::middleware('auth:api')->apiResource('eleves', EleveController::class);
Route::middleware('auth:api')->apiResource('matieres', MatiereController::class);
Route::middleware('auth:api')->apiResource('evaluations', EvaluationController::class);
Route::middleware('auth:api')->apiResource('ues', UeController::class);
