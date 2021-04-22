<?php

namespace App\Http\Controllers;

use App\DataProvider\DataProvider;
use App\Helper\RaceTime;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DevController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        dd(\Illuminate\Support\Facades\Request::ip());
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
