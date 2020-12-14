<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function practiceConfig()
    {
        return view('practice-config');
    }

    public function randomizer()
    {
        return view('randomizer');
    }

}
