<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;
use App\Models\Flight;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Example API route to fetch flights from MongoDB
Route::get('/flights', function () {
    return Flight::all();
});

Route::get('/flights/{id}', function ($id) {
    return Flight::find($id);
});
