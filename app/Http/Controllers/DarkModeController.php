<?php
// app/Http/Controllers/DarkModeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DarkModeController extends Controller
{
    public function toggle(Request $request)
    {
        $darkMode = !session('dark_mode', false);
        session(['dark_mode' => $darkMode]);

        return redirect()->back();
    }
}
