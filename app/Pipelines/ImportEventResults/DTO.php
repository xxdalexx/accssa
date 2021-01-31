<?php

namespace App\Pipelines\ImportEventResults;

use App\Models\Event;
use App\Models\Driver;
use App\Models\Series;
use Illuminate\Support\Collection;

class DTO
{
    protected string $eventId;

    public int $minLapCutoff;

    public string $rawApiResult; //Refactor WIP, set to string to throw error.

    public SgpACCApiResult $results;

    public Series $series;

    public Event $event;

    public Collection $eventEntries;

    public Collection $drivers;

    public function __construct($eventId, Series $series, $minLapCutoff = 20)
    {
        $this->eventId = $eventId;
        $this->series = $series;
        $this->eventEntries = collect();
        $this->minLapCutoff = $minLapCutoff;
    }

    public function loadDrivers(): self
    {
        $this->drivers = Driver::whereIn('sgp_id', $this->results->getDriverIdsFromFirstRace())->get();

        return $this;
    }

    public function missingDrivers(): Collection
    {
        $have = $this->drivers->pluck('sgp_id');
        $need = $this->results->getDriverIdsFromFirstRace();

        return $need->diff($have);
    }

    public function setEvent(Event $event): void
    {
        $this->event = $event;
    }

    public function driverIdFromSgpId(string $sgpId): int
    {
        return $this->driverModelFromSgpId($sgpId)->id;
    }

    public function driverModelFromSgpId(string $sgpId): Driver
    {
        return $this->drivers->firstWhere('sgp_id', $sgpId);
    }

    public function qualiTimeForSgpDriver(string $sgpId)
    {
        return $this->results->getFirstQualiResults()->firstWhere('driverId', $sgpId)->bestCleanLapTime;
    }

}
