<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class OneToOneController extends Controller
{
    public function show()
    {
        // Car data + Owner relation নিয়ে আসা
        $cars = Car::with('owner')->get();

        // View এ পাঠানো
        return view('show', compact('cars')); // compact('cars') জরুরি
    }
}
