<?php

namespace App\Http\Controllers;

use App\DataProvider\DataProvider;
use App\EventBonusCalculators\OnePointEachSplit;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use App\Models\Series;
use App\Pipelines\ImportEventResults\CreateMissingLocks;
use App\Pipelines\ImportEventResults\DTO;
use App\Pipelines\ImportEventResults\HandleDrivers;
use App\Pipelines\ImportEventResults\ImportEventResults;
use App\Pipelines\ImportEventResults\NewEvent;
use App\Pipelines\ImportEventResults\MakeApiCall;
use App\Pipelines\ImportEventResults\ProcessEventEntries;
use App\Pipelines\ImportEventResults\SaveAll;

class DevController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        $series = Series::find(10);

        $dto = ImportEventResults::get('0-s_Giz4-CyLbvvfJOm6L', $series, 20);

        return $dto->event->link();
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
