<?php

namespace App\Http\Controllers;

use App\DataProvider\DataProvider;
use App\Helper\RaceTime;
use App\Http\Guzzle\Sgp\SgpBase;
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
        $d = (new SgpBase)->getPreEventDetails('0Chj5LpwtGVJmOPCMYkZX');
        dd($upcomingEvents);
    }

    public function indexMissingSector()
    {
        $file = file_get_contents(base_path('json/testing.json'));
        $obj = json_decode($file);

        $last = null;
        foreach ($obj->race->results as $result) {
            if ($last) {
                if (
                    $result->lapCount == $last->lapCount &&
                    $result->totalTime < $last->totalTime
                ) {
                    $adjustedTime = $result->totalTime + $this->getLastSector3Time($obj, $result->driverId);
                    if ($adjustedTime < $last->totalTime) {
                        $adjustedTime = $adjustedTime + $this->getLastSector2Time($obj, $result->driverId);
                    }
                    $adjustedTime = new RaceTime($adjustedTime);
                    dump($result->driverName . ' Adjusted Time: ' . $adjustedTime->withHour());
                }
            }
            $last = $result;
//            dump($result->driverName, $result->lapCount, $result->totalTime);
        }

//        $c = collect($obj->results[3]->laps);
//        dd($c->where('driverId', 'Mza-9bHW1F1VqjeXcKcau'));
    }

    public function getLastSector3Time($obj, $driverId)
    {
        $lastLap = collect($obj->results[3]->laps)->where('driverId', $driverId)->last();
        return $lastLap->sectors[2];
    }

    public function getLastSector2Time($obj, $driverId)
    {
        $lastLap = collect($obj->results[3]->laps)->where('driverId', $driverId)->last();
        return $lastLap->sectors[1];
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
