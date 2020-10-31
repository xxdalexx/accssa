<?php

namespace App\Http\Controllers;

use App\DataProvider\DataProvider;
use App\Http\Guzzle\Sgp\SgpBase;
use App\Models\DriverScore;
use App\SingleUseFeatures\AbandondedMembers;

class DevController extends Controller
{

    public function index()
    {
        $tracks = [
            "barcelona" => 0,
            "brands_hatch" => 0,
            "barcelona_2019" => 0,
            "brands_hatch_2019" => 0,
            "hungaroring" => 0,
            "hungaroring_2019" => 0,
            "kyalami_2019" => 0,
            "laguna_seca_2019" => 0,
            "misano" => 0,
            "misano_2019" => 0,
            "monza" => 0,
            "monza_2019" => 0,
            "mount_panorama_2019" => 0,
            "nurburgring" => 0,
            "nurburgring_2019" => 0,
            "paul_ricard" => 0,
            "paul_ricard_2019" => 0,
            "silverstone" => 0,
            "silverstone_2019" => 0,
            "spa" => 0,
            "spa_2019" => 0,
            "suzuka_2019" => 0,
            "zandvoort" => 0,
            "zandvoort_2019" => 0,
            "zolder" => 0,
            "zolder_2019" => 0
        ];
        $scores = DriverScore::all();

        foreach ($tracks as $track => $score) {
            $tracks[$track] = $scores->where($track, '>', 0)->count();
        }

        dd(collect($tracks)->sort());
    }
}
