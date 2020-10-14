<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function show(Series $series)
    {
        return view('series.show')->withPoints($series->getStandings());
    }

    public function showDropOne(Series $series)
    {
        return view('series.show')->withPoints($series->getStandingsDropOne());
    }
}
