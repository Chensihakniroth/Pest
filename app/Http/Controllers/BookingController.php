<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('bookings.index');
    }

    public function create(Request $request)
    {
        // flight_id comes from search results
        $flightId = $request->query('flight_id');
        return view('bookings.create', ['flightId' => $flightId]);
    }

    public function show($id)
    {
        return view('bookings.show', ['id' => $id]);
    }

    public function boardingPass($id)
    {
        return view('bookings.boarding-pass', ['id' => $id]);
    }
}
