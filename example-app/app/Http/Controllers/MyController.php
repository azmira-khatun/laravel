<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Profile;
use app\Models\User;

class MyController extends Controller
{
    public function show()
    {
        $profiles=profile ::all();
        return $profiles;
return view('show',compact('profiles'));
    }
}
