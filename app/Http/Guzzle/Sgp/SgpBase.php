<?php

namespace App\Http\Guzzle\Sgp;

use App\Http\Guzzle\GuzzleBase;
use App\Http\Guzzle\Sgp\Cleaners\DriverResultsCleaner;
use App\Http\Guzzle\Sgp\Cleaners\EventResultsCleaner;

class SgpBase extends GuzzleBase
{
    public function __construct()
    {
        $this->params = [
            'headers' => [
                'Authorization' => 'Bearer ' . env('SGP_AUTH_TOKEN'),
                'Accept'        => 'application/json',
            ]
        ];
    }

    protected function setClientToSession($eventId)
    {
        $this->client = new \GuzzleHttp\Client(['base_uri' => "https://stg-api.simracing.gp/stg/sessions/$eventId"]);

        return $this;
    }

    protected function setClientToEvent($eventId)
    {
        $this->client = new \GuzzleHttp\Client(['base_uri' => "https://stg-api.simracing.gp/stg/event/$eventId"]);

        return $this;
    }

    protected function setClientToResults($eventId)
    {
        $this->client = new \GuzzleHttp\Client(['base_uri' => "https://stg-api.simracing.gp/stg/results/$eventId"]);

        return $this;
    }

    protected function setClientToDriverResults($driverId)
    {
        $this->client = new \GuzzleHttp\Client(['base_uri' => "https://stg-api.simracing.gp/stg/driver-results/$driverId"]);

        return $this;
    }

    protected function setClientToLeagueSessions()
    {
        $this->client = new \GuzzleHttp\Client(['base_uri' => "https://stg-api.simracing.gp/stg/session-views/league-sessions"]);

        return $this;
    }

    public function getEventResults(string $eventId, $minLaps = 20)
    {
        $this->setClientToResults($eventId);
        $cleaner = new EventResultsCleaner($this->getResponse(), $minLaps);
        return $cleaner->getCleaned();
    }

    public function getDriverResults(string $driverId)
    {
        $this->setClientToDriverResults($driverId);
        $cleaner = new DriverResultsCleaner($this->getResponse());
        return $cleaner->getCleaned();
    }

    public function getLeagueSessions()
    {
        $this->setClientToLeagueSessions();
        $this->buildQuery('leagueId', 'ikG1uiyY6vvTGCTAL486M');
        $gameString = '["acc","assetto_corsa"]';
        $this->buildQuery('games', $gameString);
        $this->buildQuery('limit', '12');
        $this->buildQuery('offset', '0');
        return $this->getResponse();
    }
}
