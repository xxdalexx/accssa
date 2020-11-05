<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show()
    {
        return view('user.show')->with([
            'tracksByStrength' => Auth::user()->driver->score->tracksByStrength()
        ]);
    }
}
