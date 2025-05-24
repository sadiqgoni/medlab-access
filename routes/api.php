<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NearbyFacilityController;
use App\Http\Controllers\Api\FacilityServiceController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Public API routes for order creation process
Route::get('/nearby-facilities', [NearbyFacilityController::class, 'index']);
Route::get('/facilities/{facility}/services', [FacilityServiceController::class, 'index']);
