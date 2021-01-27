<?php

namespace App\Pipelines\ImportEventResults;

use App\Models\Event;
use App\Models\Driver;
use App\Models\Series;
use Illuminate\Support\Collection;

class DTO
{
    protected string $eventId;

    public $rawApiResult;

    public Series $series;

    public Event $event;

    public Collection $drivers;

    public function __construct($eventId, Series $series)
    {
        $this->eventId = $eventId;
        $this->series = $series;
    }

    public function loadDrivers(): void
    {
        $this->drivers = Driver::whereIn('sgp_id', $this->getDriverIdsFromRace())->get();
    }

    public function missingDrivers(): Collection
    {
        $have = $this->drivers->pluck('sgp_id');
        $need = $this->getDriverIdsFromRace();

        return $need->diff($have);
    }

    public function setEvent(Event $event): void
    {
        $this->event = $event;
    }

    public function getRacesFromResponse(): Collection
    {
        $collection = collect($this->rawApiResult->results);
        return $collection->where('type', 'RACE');
    }

    public function getFirstRaceResults(): Collection
    {
        $race = $this->getRacesFromResponse()->first();
        return collect($race->results);
    }

    public function getDriverIdsFromRace(): Collection
    {
        $results = $this->getFirstRaceResults();
        return $results->pluck('driverId');
    }
}
