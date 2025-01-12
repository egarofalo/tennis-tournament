<?php

use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TournamentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource(
    'tournaments',
    TournamentController::class
)->only(['index', 'store', 'show']);

Route::apiResource(
    'players',
    PlayerController::class
)->only(['index', 'show']);
