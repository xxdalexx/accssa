<?php

namespace App\Http\Controllers;

use App\DataProvider\DataProvider;
use App\Http\Guzzle\Sgp\Get\LeagueViews;
use App\Http\Guzzle\Sgp\Get\Responses\LeagueViewsResponse;
use App\Http\Guzzle\Sgp\SgpApi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\Mocks\SgpLeagueViewsMock;

class DevController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        dd(app());
    }

    public function acTracksindex()
    {
        $tracks = (new DataProvider)->getAcTracks();
        dd($tracks->sortBy('length')->skip(30));
    }

    public function aindex()
    {
        return redirect()->route('home');
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
