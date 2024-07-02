<?php
// routes/api.php

use App\Http\Controllers\InternetServiceProviderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SpeedTestController;
use App\Http\Controllers\ServiceProviderController;
use App\Http\Controllers\CoverageAreaController;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\PlanDetailController;
use App\Http\Controllers\ServiceProviderAliasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('service_providers', ServiceProviderController::class);
    Route::apiResource('coverage_areas', CoverageAreaController::class);
    Route::apiResource('service_types', ServiceTypeController::class);
    Route::apiResource('plan_details', PlanDetailController::class);
    Route::apiResource('service_provider_aliases', ServiceProviderAliasController::class);
    Route::get('available_providers', [ServiceProviderAliasController::class, 'availableProviders']);

    Route::apiResource('users', UserController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::get('/speedtest/download', [SpeedTestController::class, 'downloadTest']);
Route::post('/speedtest/upload', [SpeedTestController::class, 'uploadTest']);
Route::get('/speedtest/jitter', [SpeedTestController::class, 'jitterTest']);
Route::get('/speedtest/packet_loss', [SpeedTestController::class, 'packetLossTest']);
Route::get('/speedtest/ping', [SpeedTestController::class, 'pingTest']);
Route::get('/speedtest/latency', [SpeedTestController::class, 'latencyTest']);
Route::get('/ipinfo/token', [SpeedTestController::class, 'getIpInfoToken']);
Route::post('/speedtest/results', [SpeedTestController::class, 'storeResults']);
Route::get('/speedtest/recommendations', [SpeedTestController::class, 'recommendIsp']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::apiResource('isps', InternetServiceProviderController::class);
