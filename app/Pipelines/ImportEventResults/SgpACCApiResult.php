<?php

namespace App\Pipelines\ImportEventResults;

use Illuminate\Support\Collection;

class SgpACCApiResult extends Collection
{
    protected Collection $races;

    protected Collection $firstRaceResults;

    protected Collection $qualis;

    protected Collection $firstQualiResults;

    protected Collection $driverIds;

    public static function load($results): self
    {
        $instance = new self($results);

        $sessions = collect($instance->get('results'));

        $instance->races = $sessions->where('type', 'RACE');
        $instance->firstRaceResults = collect($instance->races->first()->results);

        $instance->qualis = $sessions->where('type', 'QUALIFY');
        $instance->firstQualiResults = collect($instance->qualis->first()->results);

        return $instance;
    }

    public function getTrackName()
    {
        return $this->get('trackName');
    }

    public function getSgpSessionId()
    {
        return $this->get('sessionId');
    }

    public function getSessionName()
    {
        return $this->get('sessionName');
    }

    public function getFirstRaceResults()
    {
        return $this->firstRaceResults;
    }

    public function getFirstQualiResults()
    {
        return $this->firstQualiResults;
    }

    public function getDriverIdsFromFirstRace()
    {
        return $this->firstRaceResults->pluck('driverId');
    }

}
