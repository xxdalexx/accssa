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
        return view('open.practice-config');
    }

    public function randomizer()
    {
        return view('open.randomizer');
    }

    public function addDriver()
    {
        return view('open.add-driver');
    }

}
