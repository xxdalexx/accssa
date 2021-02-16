<?php

namespace App\Http\Controllers;

use App\DataProvider\DataProvider;
use App\Helper\RaceTime;
use App\Http\Guzzle\Sgp\Get\DriverResults;
use App\Http\Guzzle\Sgp\Get\EventResults;
use App\Http\Guzzle\Sgp\Get\LeagueViews;
use App\Http\Guzzle\Sgp\Get\Responses\LeagueViewsResponse;
use App\Http\Guzzle\Sgp\Get\Responses\SessionResponse;
use App\Http\Guzzle\Sgp\Get\Session;
use App\Http\Guzzle\Sgp\Responses\SgpDriverResultsResponse;
use App\Http\Guzzle\Sgp\SgpApi;
use App\Models\AccCar;
use App\Models\Car;
use App\Models\EventEntry;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
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
        $file = fake_sgp('driver-results\forTest.json');
        $results = json_decode(file_get_contents($file));

        $response = new SgpDriverResultsResponse();
        $response->setRawData($results);
        dd($response->getFormattedListForTrackTimes());
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
