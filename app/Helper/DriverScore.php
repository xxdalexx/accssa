<?php

namespace App\Helper;

use App\Http\Guzzle\Sgp\SgpBase;

class DriverScore
{
    protected $trackTimes;
    protected $alienTimes = [
        "barcelona_2019" => 101900,
        "brands_hatch_2019" => 82200,
        "kyalami_2019" => 99390,
        "laguna_seca_2019" => 80800,
        "misano_2019" => 92400,
        "mount_panorama_2019" => 119800,
        "nurburgring_2019" => 112300,
        "silverstone_2019" => 116000,
        "spa_2019" => 135900,
        "suzuka_2019" => 118200,
        "zandvoort_2019" => 94500,
        "zolder_2019" => 87650,
    ];
    protected $score;

    public function __construct(string $sgpDriverId)
    {
        $this->trackTimes = (new SgpBase)->getDriverResults($sgpDriverId);

        foreach ($this->trackTimes as $track => $time) {
            $score[$track] = $time - $this->alienTimes[$track];
        }

        $this->score = collect($score)->sort()->take(5)->avg();
    }

    public function getScore()
    {
        return $this->score;
    }
}
