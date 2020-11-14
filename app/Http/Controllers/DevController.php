<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Driver;
use App\Models\DriverScore;
use App\Http\Guzzle\Sgp\SgpBase;
use App\DataProvider\DataProvider;
use Illuminate\Support\Facades\Auth;
use App\Helper\DriverScoreCalculator;
use App\SingleUseFeatures\AbandondedMembers;

class DevController extends Controller
{
    public function index()
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
