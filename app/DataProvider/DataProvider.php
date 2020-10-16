<?php

namespace App\DataProvider;

class DataProvider
{
    public function getCars()
    {
        $path = __DIR__ . '\cars.json';
        $parsed = json_decode(file_get_contents($path));
        return collect($parsed);
    }

    public function getTracks()
    {
        $path = __DIR__ . '\tracks.json';
        $parsed = json_decode(file_get_contents($path));
        return collect($parsed);
    }

    public function gimmeAGT3Car()
    {
        return $this->getCars()->where('id', '<', 24)->random()->name;
    }

    public function gimmeATrack()
    {
        return $this->getTracks()->random()->name;
    }
}
