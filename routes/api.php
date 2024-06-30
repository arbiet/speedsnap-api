<?php
// routes/api.php

use App\Http\Controllers\InternetServiceProviderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SpeedTestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/speedtest/download', [SpeedTestController::class, 'downloadTest']);
    Route::post('/speedtest/upload', [SpeedTestController::class, 'uploadTest']);
    Route::get('/speedtest/jitter', [SpeedTestController::class, 'jitterTest']);
    Route::get('/speedtest/packet_loss', [SpeedTestController::class, 'packetLossTest']);
    Route::get('/speedtest/ping', [SpeedTestController::class, 'pingTest']);
    Route::get('/speedtest/latency', [SpeedTestController::class, 'latencyTest']);
    Route::get('/ipinfo/token', [SpeedTestController::class, 'getIpInfoToken']);
    Route::post('/speedtest/results', [SpeedTestController::class, 'storeResults']);
    Route::get('/speedtest/recommendations', [SpeedTestController::class, 'recommendIsp']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('users', UserController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::apiResource('isps', InternetServiceProviderController::class);
