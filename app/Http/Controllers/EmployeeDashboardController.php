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
        // Use caching for better performance (cache for 5 minutes)
        $users = cache()->remember('dashboard_users', 300, function () {
            return User::latest()->take(20)->get(); // Limit to 20 most recent users
        });

        $flights = cache()->remember('dashboard_flights', 300, function () {
            return Flight::with(['originAirport', 'destinationAirport'])
                            ->latest()
                            ->take(10)
                            ->get(); // Limit to 10 most recent flights
        });

        $bookings = cache()->remember('dashboard_bookings', 300, function () {
            return Booking::with(['user', 'flight.originAirport', 'flight.destinationAirport'])
                              ->latest()
                              ->take(15)
                              ->get(); // Limit to 15 most recent bookings
        });

        // Add summary statistics for dashboard (also cached)
        $stats = cache()->remember('dashboard_stats', 300, function () {
            return [
                'total_revenue' => Booking::sum('total_price'),
                'active_bookings' => Booking::where('status', 'confirmed')->count(),
                'total_users' => User::count(),
            ];
        });

        return view('employee.dashboard', compact('users', 'flights', 'bookings', 'stats'));
    }
}
