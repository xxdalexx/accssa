<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Support\Facades\Auth;
use App\Models\Series;
use App\Pipelines\ImportEventResults\CreateMissingLocks;
use App\Pipelines\ImportEventResults\DTO;
use App\Pipelines\ImportEventResults\HandleDrivers;
use App\Pipelines\ImportEventResults\NewEvent;
use App\Pipelines\ImportEventResults\MakeApiCall;

class DevController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        $pipes = [
            MakeApiCall::class,
            NewEvent::class,
            HandleDrivers::class,
            CreateMissingLocks::class
        ];

        $series = Series::find(7);

        $passable = new DTO('0-s_Giz4-CyLbvvfJOm6L', $series);

        $dto = app('Illuminate\Pipeline\Pipeline')
            ->send($passable)
            ->through($pipes)
            ->thenReturn();

        dd($dto);

        //Build event entry records
        $entry = new stdClass;
        $entry->driver_id;
        $entry->event_id;
        $entry->position;
        $entry->laps;
        $entry->quali_time;
        $entry->total_time;
        $entry->race_number;
        $entry->penalty_points;
        $entry->best_lap_points;
        $entry->points;
        $entry->final_points;
        $entry->split;
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
