<?php

namespace App\Http\Controllers;

use App\Http\Guzzle\Sgp\SgpBase;
use App\Models\Series;
use Illuminate\Http\Request;

class DevController extends Controller
{
    public function index(): void
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
