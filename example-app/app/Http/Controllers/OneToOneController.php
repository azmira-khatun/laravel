<?php

namespace App\Http\Controllers;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class OneToOneController extends Controller
{
 public function show()
    {
        $profiles = Profile::all();
        // return $profiles;
        return view('show', compact('profiles'));
    }
}
