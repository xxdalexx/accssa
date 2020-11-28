<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Guzzle\Sgp\SgpBase;
use App\Helper\NeededTrackListing;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function sgpToken()
    {
        return view('admin.sgp-token');
    }

    public function neededTracks()
    {
        return view('admin.needed-tracks')->with([
            'neededTracks' => NeededTrackListing::get(),
            'reverseTimeline' => $this->reverseTrackTimeline()
        ]);
    }

    public function importEvent()
    {
        return view('admin.import-event');
    }

    public function lockOverride()
    {
        return view('admin.locks');
    }

    public function discord()
    {
        return view('admin.snowflakes');
    }

    public function preEvent()
    {
        return view('admin.pre-event-checks');
    }

    protected function reverseTrackTimeline()
    {
        $response = (new SgpBase)->bustCache()->getLeagueHistory();
        return collect($response)->pluck('trackName')->unique()->reverse();
    }
}
