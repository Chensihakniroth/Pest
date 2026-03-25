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
Route::apiResource('flights', FlightController::class)->names('api.flights');

// Users API
Route::apiResource('users', UserController::class)->names('api.users');
Route::post('users/{id}/toggle-restriction', [UserController::class, 'toggleRestriction'])->name('api.users.toggle-restriction');

// Bookings API
Route::apiResource('bookings', BookingController::class)->names('api.bookings');
