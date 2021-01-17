<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Series;
use App\Http\Guzzle\Sgp\SgpBase;
use App\Http\Guzzle\Sgp\SgpPost;
use Illuminate\Support\Facades\Auth;
use App\Http\Guzzle\Sgp\RequestBuilders\RemoveDriverFromEvent;

class DevController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        $s = Series::find(5);
        dd($s->events->each->eventEntries->each->driver);
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
