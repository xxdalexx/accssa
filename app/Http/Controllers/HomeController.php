<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $series = Series::find(1);

        return view('home')->withPoints($series->getStandings());
    }

}
