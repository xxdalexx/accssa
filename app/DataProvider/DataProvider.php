<?php

namespace App\DataProvider;

use Illuminate\Support\Collection;

class DataProvider
{
    protected Collection $cars;
    protected Collection $tracks;
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

    public function __construct()
    {
        $carPath = __DIR__ . '/cars.json';
        $trackPath = __DIR__ . '/tracks.json';

        $this->cars = collect(json_decode(file_get_contents($carPath)));
        $this->tracks = collect(json_decode(file_get_contents($trackPath)));
    }

    public function getCars()
    {
        return $this->cars;
    }

    public function getTracks()
    {
        return $this->tracks;
    }

    public function gimmeAGT3Car()
    {
        return $this->cars->take(26)->random()->name;
    }

    public function gimmeAGT4Car()
    {
        return $this->cars->where('dlc', 'GT4 Pack')->random()->name;
    }

    public function gimmeATrack()
    {
        return $this->tracks->random()->name;
    }

    public function getAlienTimes(): array
    {
        return $this->alienTimes;
    }

    public function getIncidentStatuses()
    {
        return [
            0 => 'Awaiting Response From Accused',
            1 => 'Accepted By Accused',
            2 => 'Awaiting Review',
            3 => 'Reviewed - Penalty Confirmed',
            4 => 'Reviewed - No Action Taken'
        ];
    }
}
