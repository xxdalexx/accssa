<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Driver;
use App\Models\SeriesLock;
use App\Models\DriverScore;
use Illuminate\Support\Str;
use App\Http\Guzzle\Sgp\SgpBase;
use App\DataProvider\DataProvider;
use Illuminate\Support\Facades\Auth;
use App\Helper\DriverScoreCalculator;
use App\Notifications\TestNotification;
use NotificationChannels\Discord\Discord;
use App\Notifications\DiscordNotification;
use App\SingleUseFeatures\AbandondedMembers;

class DevController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        $tracks = (new DataProvider)->getTracks();
        dd($tracks->keys()->filter(function ($value, $key) {
            return Str::endsWith($value, '2020');
        }));
        // $response = (new SgpBase)->bustCache()->getUpcomingEvents('acc');
        // dd($response);
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

}
