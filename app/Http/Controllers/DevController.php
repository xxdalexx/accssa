<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\DriverScore;
use App\Http\Guzzle\Sgp\SgpBase;
use App\DataProvider\DataProvider;
use App\SingleUseFeatures\AbandondedMembers;

class DevController extends Controller
{

    public function index()
    {
        //$r = (new SgpBase)->getUserDetails('75d083a9-66b3-4226-bce4-dd986ecf6955');
        $r = (new SgpBase)->getLeagueMemberList();
        $id = '75d083a9-66b3-4226-bce4-dd986ecf6955';
        dd($r->members->$id);
    }

    public function FindNeededTracksindex()
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
