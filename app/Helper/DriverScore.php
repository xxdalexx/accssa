<?php

namespace App\Helper;

use App\Http\Guzzle\Sgp\SgpBase;

class DriverScore
{
    protected $trackTimes;
    protected $alienTimes = [
        "barcelona" => 101900,
        "barcelona_2019" => 102500,
        "brands_hatch_2019" => 82200,
        "hungaroring_2019" => 101500,
        "kyalami_2019" => 99390,
        "laguna_seca_2019" => 80800,
        "misano_2019" => 92400,
        "monza_2019" => 106400,
        "mount_panorama_2019" => 119800,
        "nurburgring_2019" => 112300,
        "paul_ricard" => 114200,
        "paul_ricard_2019" => 113200,
        "silverstone" => 116000,
        "silverstone_2019" => 117000,
        "spa" => 135900,
        "spa_2019" => 136900,
        "suzuka_2019" => 118200,
        "zandvoort_2019" => 94500,
        "zolder_2019" => 87650,
    ];
    protected $score;

    public function __construct(string $sgpDriverId)
    {
        $this->trackTimes = (new SgpBase)->getDriverResultsForScore($sgpDriverId);

        foreach ($this->trackTimes as $track => $time) {
            if ($calculatedScore = $this->calculateScore($track, $time)) {
                $score[$track] = $calculatedScore;
            }
        }

        if (count($score) > 2) {
            $this->score = collect($score)->sort()->take(5)->avg();
        } else {
            $this->score = 0;
        }
    }

    protected function calculateScore($track, $time)
    {
        if (!array_key_exists($track, $this->alienTimes)) {
            $score = $time - $this->alienTimes[$track . '_2019'];
        } else {
            $score = $time - $this->alienTimes[$track];
        }

        if ($score > 10000) {
            return false;
        }
        return $score;
    }

    public function getScore()
    {
        if (count($this->trackTimes) > 2) {
            return (int) $this->score;
        }
        return 0;
    }
}
