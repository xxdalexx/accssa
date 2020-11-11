<?php

namespace App\Http\Livewire;

use Livewire\Component;

class EventIncidents extends Component
{
    public $event;

    public $penalty = "1";
    public $accusedId = "0";
    public $victimId = "0";
    public $timestamp;
    public $description;

    public function getDriverListProperty()
    {
        $drivers = [];
        foreach($this->event->eventEntries as $entry) {
            $drivers[$entry->driver->id] = $entry->driver->driver_name;
        }
        return $drivers;
    }

    public function newIncident()
    {
        dd('hit');
    }

    public function render()
    {
        return view('livewire.event-incidents');
    }
}
