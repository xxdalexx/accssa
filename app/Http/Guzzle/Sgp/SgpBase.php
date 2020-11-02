<?php

namespace App\Http\Guzzle\Sgp;

use App\Http\Guzzle\GuzzleBase;
use App\Http\Guzzle\Sgp\Cleaners\EventResultsCleaner;
use App\Http\Guzzle\Sgp\Cleaners\DriverResultsForScoreCleaner;
use App\Models\Site;

class SgpBase extends GuzzleBase
{
    public function __construct()
    {
        $this->params = [
            'headers' => [
                'Authorization' => 'Bearer ' . Site::sgpToken(),
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

    protected function setClientToLeagueViews($leagueId)
    {
        //ACCSSA Hard Coded
        $this->client = new \GuzzleHttp\Client(['base_uri' => "https://stg-api.simracing.gp/stg/league-views/$leagueId"]);

        return $this;
    }

    public function getLeagueMemberList()
    {
        $this->cacheName = 'leagueMemberList.' . 'ikG1uiyY6vvTGCTAL486M';

        $this->setClientToLeagueViews('ikG1uiyY6vvTGCTAL486M');
        return $this->getResponse();
    }

    public function getEventResults(string $eventId, $minLaps = 20)
    {
        $this->cacheName = 'eventResults.' . $eventId;

        $this->setClientToResults($eventId);
        $cleaner = new EventResultsCleaner($this->getResponse(), $minLaps);
        return $cleaner->getCleaned();
    }

    public function getDriverResults(string $driverId)
    {
        $this->cacheName = 'driverResults.' . $driverId;

        $this->setClientToDriverResults($driverId);
        return $this->getResponse();
    }

    public function getDriverResultsForScore(string $driverId)
    {
        $this->cacheName = 'driverResultsForScore.' . $driverId;

        $this->setClientToDriverResults($driverId);
        $cleaner = new DriverResultsForScoreCleaner($this->getResponse());
        return $cleaner->getCleaned();
    }

    public function getLeagueSessions()
    {
        $this->cacheName = 'leagueSessions.' . 'ikG1uiyY6vvTGCTAL486M';

        $this->setClientToLeagueSessions();
        $this->buildQuery('leagueId', 'ikG1uiyY6vvTGCTAL486M');
        $gameString = '["acc","assetto_corsa"]';
        $this->buildQuery('games', $gameString);
        $this->buildQuery('limit', '12');
        $this->buildQuery('offset', '0');
        dd($this);
        return $this->getResponse();
    }
}
