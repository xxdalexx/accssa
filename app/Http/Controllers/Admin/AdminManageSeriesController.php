<?php

namespace App\Http\Controllers\Admin;

use App\Http\Guzzle\Sgp\SgpBase;
use App\Helper\NeededTrackListing;
use App\Http\Controllers\Controller;

class AdminManageSeriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage users');
    }

    public function importEvent()
    {
        return view('admin.import-event');
    }

    public function lockOverride()
    {
        return view('admin.locks');
    }

    public function preEvent()
    {
        return view('admin.pre-event-checks');
    }

    public function neededTracks()
    {
        return view('admin.needed-tracks')->with([
            'neededTracks' => NeededTrackListing::get(),
            'reverseTimeline' => $this->reverseTrackTimeline()
        ]);
    }

    protected function reverseTrackTimeline()
    {
        $response = (new SgpBase)->bustCache()->getLeagueHistory();
        return collect($response)->pluck('trackName')->unique()->reverse();
    }
}
