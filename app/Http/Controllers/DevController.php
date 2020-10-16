<?php

namespace App\Http\Controllers;

use App\DataProvider\DataProvider;
use App\Helper\DriverScore;
use App\Http\Guzzle\Sgp\SgpBase;
use App\Models\Series;
use Illuminate\Http\Request;

class DevController extends Controller
{
    public function index()
    {
        dd((new DriverScore('QEau6D9p27CRYNEFqFVj1'))->getScore());
    }

    public function splitStandingsIndex(): void
    {
        $series = Series::first();
        $standings = collect($series->getStandingsDropOne());
        $split = $standings->split(2);
        dd($split->toArray());
    }

    public function leagueSessionsIndex()
    {
        $apiResponse = (new SgpBase)->getLeagueSessions();
        dd($apiResponse);
    }

    public function standingsIndex(): void
    {
        //Get all drivers for series
        $points = [];
        $series = Series::first();

        dd($series->getStandings());
    }

    public function jsonIndex(): void
    {
        $path = __DIR__ . '\..\..\..\json.json';
        $parsed = json_decode(file_get_contents($path));
        dd($parsed->results[2]->results);
    }
}
