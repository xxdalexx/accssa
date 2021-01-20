<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Driver;
use App\Models\Series;
use App\Http\Guzzle\Sgp\SgpBase;
use App\Http\Guzzle\Sgp\SgpPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SeriesStartNotification;
use App\Http\Guzzle\Sgp\RequestBuilders\RemoveDriverFromEvent;
use App\SingleUseFeatures\MembersMissingDiscordOnSgp;

class DevController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        MembersMissingDiscordOnSgp::run();
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
