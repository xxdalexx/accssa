<?php

namespace App\Http\Livewire;

use App\DataProvider\DataProvider;
use Livewire\Component;

class CarTrackRandomizer extends Component
{
    protected DataProvider $dataProvider;

    public $trackName;
    public $entrants = [
        'Dale Carter' => null
    ];

    public $newEntrantName;

    public function mount()
    {
        $this->dataProvider = app('DataProvider');
        $this->repickTrack();
        $this->repickCar('Dale Carter');
    }

    public function hydrate()
    {
        $this->dataProvider = app('DataProvider');
    }

    public function repickTrack()
    {
        $this->trackName = $this->dataProvider->gimmeATrack();
    }

    public function repickCar($name)
    {
        $this->entrants[$name] = $this->dataProvider->gimmeAGT3Car();
    }

    public function deleteEntrant($name)
    {
        unset($this->entrants[$name]);
    }

    public function addEntrant()
    {
        if (empty($this->newEntrantName)) {
            return;
        }

        $this->entrants[$this->newEntrantName] = $this->dataProvider->gimmeAGT3Car();
        $this->newEntrantName = '';
    }

    public function render()
    {
        return view('livewire.car-track-randomizer');
    }
}
