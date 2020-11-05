<?php

namespace App\Http\Controllers;

use App\Helper\NeededTrackListing;
use Illuminate\Http\Request;
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
            'neededTracks' => NeededTrackListing::get()
        ]);
    }
}
