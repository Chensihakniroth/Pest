<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Flight;
use App\Models\Booking;
use Illuminate\Http\Request;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        $flights = Flight::with(['originAirport', 'destinationAirport'])->latest()->get();
        $bookings = Booking::with(['user', 'flight.originAirport', 'flight.destinationAirport'])->latest()->get();

        return view('employee.dashboard', compact('users', 'flights', 'bookings'));
    }
}
