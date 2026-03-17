<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        // No more database calls in PHP! 
        // Data will be fetched via AJAX from the Node.js backend.
        return view('employee.dashboard');
    }
}
