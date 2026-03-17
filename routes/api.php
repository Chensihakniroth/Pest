<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FlightController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BookingController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Flights API
Route::apiResource('flights', FlightController::class);

// Users API
Route::apiResource('users', UserController::class);
Route::post('users/{id}/toggle-restriction', [UserController::class, 'toggleRestriction']);

// Bookings API
Route::apiResource('bookings', BookingController::class);
