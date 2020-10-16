<?php

namespace App\Http\Controllers;

use App\DataProvider\DataProvider;
use App\Helper\DriverScore;
use App\Http\Guzzle\Sgp\SgpBase;
use App\Models\Driver;
use App\Models\Series;
use Illuminate\Http\Request;

class DevController extends Controller
{
    public function index()
    {
        foreach (Driver::orderBy('driver_score')->get() as $driver) {
            echo($driver->driver_name . ' - ' . $driver->driver_score . "<br>");
        }
    }

    public function RunDriverScoresindex()
    {
        //ignore 29 32
        foreach (Driver::where('id', '>', 32)->get() as $driver) {
            $score = (new DriverScore($driver->sgp_id))->getScore();
            dump($driver->id . $driver->driver_name . ' - ' . $score);
            $driver->driver_score = $score;
            $driver->save();
        }

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
