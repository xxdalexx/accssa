<?php

namespace App\DataProvider;

use Illuminate\Support\Collection;

class DataProvider
{
    protected Collection $cars;
    protected Collection $tracks;

    public function __construct()
    {
        $carPath = __DIR__ . '\cars.json';
        $trackPath = __DIR__ . '\tracks.json';

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
        return $this->cars->take(24)->random()->name;
    }

    public function gimmeATrack()
    {
        return $this->tracks->random()->name;
    }
}
