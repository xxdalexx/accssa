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
use App\Models\AccCar;
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
        $formatted = $this->formatDriversTimes();
        dd($formatted);
        $this->processSims($formatted);
    }

    public function formatDriversTimes()
    {
        $api = new DriverResults();
        $response = collect($api->forDriver('SXs33IH-ZDSa6A2hUzKU_')->get());

        return $response->map(function ($event) {
            $results = collect($event->results)->filter(function ($result) {
                return $result->type == "RACE" && is_int($result->bestLapTime);
            })->each(function ($result) use ($event) {
                $result->carModelId = $event->carModelId;
                $result->sim = $event->game;
                $result->trackId = $event->trackId;
            })->map(function ($result) {
                return collect($result)->only(['trackId', 'carModelId', 'sim', 'bestLapTime']);
            });
            return $results->toArray();
        })->flatten(1)->groupBy('trackId')->groupBy('0.sim', true);
    }

    protected function processSims($formatted)
    {
        $formatted->each(function ($tracks, $sim) {
            $method = $sim . 'CleanTracks';
            return $this->$method($tracks);
        });
    }

    protected function accCleanTracks($tracks)
    {
        $carIds = collect(data_get($tracks, '*.*.carModelId'))->unique();
        $cars = AccCar::select(['id', 'type'])->whereIn('id', $carIds)->get();

        $tracks->transform(function ($races) use ($cars) {
            $races = $this->injectCarTypesIntoRaceResultsForAcc($races, $cars);
            return $races->groupBy('carType');
        });

        dd($tracks);
    }

    protected function injectCarTypesIntoRaceResultsForAcc($races, $cars)
    {
        return $races->transform(function ($race) use ($cars) {
            $race['carType'] = $cars->find($race['carModelId'])->type;
            return $race;
        });
    }

    protected function acCleanTracks($track)
    {

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
