<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function searchForm()
    {
        // Hybrid Mode: Return the Blade UI shell only.
        return view('flights.search');
    }

    public function index()
    {
        return view('flights.index');
    }

    public function show($id)
    {
        return view('flights.show', ['id' => $id]);
    }
}
