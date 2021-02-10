<?php

namespace App\Http\Controllers;

use App\DataProvider\DataProvider;
use App\Helper\RaceTime;
use App\Http\Guzzle\Sgp\Get\DriverResults;
use App\Http\Guzzle\Sgp\Get\EventResults;
use App\Http\Guzzle\Sgp\Get\LeagueViews;
use App\Http\Guzzle\Sgp\Get\Responses\DriverResultsResponse;
use App\Http\Guzzle\Sgp\Get\Responses\LeagueViewsResponse;
use App\Http\Guzzle\Sgp\Get\Responses\SessionResponse;
use App\Http\Guzzle\Sgp\Get\Session;
use App\Http\Guzzle\Sgp\SgpApi;
use App\Models\EventEntry;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\Cloner\Data;
use Tests\Mocks\SgpLeagueViewsMock;

class DevController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        return redirect()->route('home');
    }

    public function formatIncidentImport()
    {
        $rawReport = (new DataProvider)->getIncidentReport();
        $formattedReport = [];

        $offset = $rawReport['greenFlagOffset'];
        dump($offset);

        $incidents = collect($rawReport['incidents'])->where('sessionID.type', 'RACE');

        foreach ($incidents as $incident) {
            $report = [];
            $report['replayTime'] =
                (new RaceTime($offset + $incident->sessionEarliestTime))
                ->onlySeconds();
            foreach ($incident->cars as $key => $car) {
                $report['cars'][$key] = $car->carId;
            }
            $formattedReport[] = $report;
        }
        dd($formattedReport);
    }

    public function acTracksindex()
    {
        $tracks = (new DataProvider)->getAcTracks();
        dd($tracks->sortBy('length')->skip(30));
    }

    public function loginMe()
    {
        $user = User::first();
        Auth::login($user);

        return redirect()->route('home');
    }

    public function loginAs(User $user)
    {
        Auth::login($user);
        return redirect()->route('home');
    }

}
