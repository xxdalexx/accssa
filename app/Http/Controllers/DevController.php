<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\DriverScore;
use App\Http\Guzzle\Sgp\SgpBase;
use App\DataProvider\DataProvider;
use App\Helper\DriverScoreCalculator;
use App\SingleUseFeatures\AbandondedMembers;

class DevController extends Controller
{
    public function index()
    {
        $score = DriverScore::first();
        $calculator = new DriverScoreCalculator($score);
        $trackScores = collect($calculator->getTrackScores())->sort();
        $fixed = fixTrackNames($trackScores);
        dd($fixed);
    }

}
