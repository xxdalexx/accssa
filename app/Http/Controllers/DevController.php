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


}
