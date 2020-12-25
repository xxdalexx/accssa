<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $auth = collect(1);

        if (!$auth->contains(Auth::id())) {
            abort(401);
        }
        return view('open.add-driver');
    }

}
