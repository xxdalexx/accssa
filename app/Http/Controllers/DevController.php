<?php

namespace App\Http\Controllers;

use App\Http\Guzzle\Sgp\SgpBase;
use App\Models\Series;
use Illuminate\Http\Request;

class DevController extends Controller
{
    public function index()
    {
        $apiResponse = (new SgpBase)->getLeagueSessions();
        dd($apiResponse);
    }

    public function standingsindex(): void
    {
        //Get all drivers for series
        $points = [];
        $series = Series::first();

        dd($series->getStandings());
    }

    public function jsonindex(): void
    {
        $path = __DIR__ . '\..\..\..\json.json';
        $parsed = json_decode(file_get_contents($path));
        dd($parsed->results[2]->results);
    }
}
