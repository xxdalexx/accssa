<?php

namespace App\Http\Controllers;

use App\Models\User;
<<<<<<< HEAD
use Illuminate\Support\Facades\Auth;
=======
use App\Models\Driver;
use App\Models\Series;
use Illuminate\Http\Request;
use App\Http\Guzzle\Sgp\SgpApi;
use App\Http\Guzzle\Sgp\SgpBase;
use App\Http\Guzzle\Sgp\SgpPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SeriesStartNotification;
use App\SingleUseFeatures\MembersMissingDiscordOnSgp;
use App\Http\Guzzle\Sgp\RequestBuilders\RemoveDriverFromEvent;
>>>>>>> New design pattern for sgp api interactions.

class DevController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        dd(SgpApi::results('0-s_Giz4-CyLbvvfJOm6L'));
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
