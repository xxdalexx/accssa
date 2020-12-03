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
        $this->client = new \GuzzleHttp\Client(['base_uri' => "https://stg-api.simracing.gp/stg/league-views/$leagueId"]);

        return $this;
    }

    protected function setClientToUserViews($userId)
    {
        $this->client = new \GuzzleHttp\Client(['base_uri' => "https://stg-api.simracing.gp/stg/user-views/$userId"]);

        return $this;
    }

    protected function setClientToLeagueHistory($leagueId)
    {
        $this->client = new \GuzzleHttp\Client(['base_uri' => "https://stg-api.simracing.gp/stg/query/session-history/by-league/$leagueId"]);

        return $this;
    }

    public function getLeagueHistory()
    {
        $leagueId = Site::sgpLeagueId();
        $this->cacheName = 'leagueHistory' . $leagueId;

        $this->setClientToLeagueHistory($leagueId);
        $this->buildQuery('offset', 0);
        $this->buildQuery('limit', 1000);
        return $this->getResponse();
    }

    public function getLeagueMemberList()
    {
        $leagueId = Site::sgpLeagueId();
        $this->cacheName = 'leagueMemberList.' . $leagueId;

        $this->setClientToLeagueViews($leagueId);
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

    public function getLeagueSessions($onlyGame = null)
    {
        if ($onlyGame == 'acc') {
            $gameString = '["acc"]';
        } elseif ($onlyGame == 'ac') {
            $gameString = '[assetto_corsa"]';
        } else {
            $gameString = '["acc","assetto_corsa"]';
        }

        $leagueId = Site::sgpLeagueId();

        $this->cacheName = 'leagueSessions.' . $leagueId;

        $this->setClientToLeagueSessions();
        $this->buildQuery('leagueId', $leagueId);
        $this->buildQuery('games', $gameString);
        $this->buildQuery('limit', '12');
        $this->buildQuery('offset', '0');
        return $this->getResponse();
    }

    public function getUpcomingEvents($game = null)
    {
        return $this->getLeagueSessions($game);
    }

    public function getUserDetails($userId)
    {
        $this->cacheName = 'userDetails' . $userId;

        $this->setClientToUserViews($userId);
        return $this->getResponse();
    }

    public function getPreEventDetails($eventId)
    {
        $this->setClientToSession($eventId);
        return $this->getResponse();
    }
}
