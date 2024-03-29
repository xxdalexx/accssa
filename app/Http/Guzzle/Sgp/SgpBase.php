<?php

namespace App\Http\Guzzle\Sgp;

use App\Http\Guzzle\GuzzleBase;
use App\Http\Guzzle\Sgp\Cleaners\EventResultsCleaner;
use App\Http\Guzzle\Sgp\Cleaners\DriverResultsForScoreCleaner;
use App\Http\Guzzle\Sgp\RequestBuilders\AddDriverToChampionship;
use App\Http\Guzzle\Sgp\RequestBuilders\AddDriverToEvent;
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

    protected function setClientToLeagueTournaments()
    {
        $this->client = new \GuzzleHttp\Client(['base_uri' => "https://stg-api.simracing.gp/stg/tournament-views/league-tournaments"]);

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

    protected function setClientToApplications($leagueId)
    {
        $this->client = new \GuzzleHttp\Client(['base_uri' => "https://stg-api.simracing.gp/stg/query/participant-application/open-league-applications/$leagueId"]);

        return $this;
    }

    public function getApplications()
    {
        $this->setClientToApplications(Site::sgpLeagueId());
        return $this->getResponse();
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
        //$this->cacheName = 'driverResultsForScore.' . $driverId;

        $this->setClientToDriverResults($driverId);
        $cleaner = new DriverResultsForScoreCleaner($this->getResponse());
        return $cleaner->getCleaned();
    }

    public function getUpcomingChampionships($onlyGame = null, $leagueId = null)
    {
        //This is going to need updated for AMS2 and RR when added.
        if ($onlyGame == 'acc') {
            $gameString = '["acc"]';
        } elseif ($onlyGame == 'ac') {
            $gameString = '[assetto_corsa"]';
        } else {
            $gameString = '["acc","assetto_corsa"]';
        }

        if (!$leagueId) {
            $leagueId = Site::sgpLeagueId();
        }

        $this->cacheName = 'leagueTournaments.' . $leagueId;

        $this->setClientToLeagueTournaments();
        $this->buildQuery('leagueId', $leagueId);
        $this->buildQuery('games', $gameString);
        $this->buildQuery('status', 'OPEN');
        $this->buildQuery('limit', '12');
        $this->buildQuery('offset', '0');
        return $this->getResponse();
    }

    public function getLeagueSessions($onlyGame = null, $leagueId = null)
    {
        //This is going to need updated for AMS2 and RR when added.
        if ($onlyGame == 'acc') {
            $gameString = '["acc"]';
        } elseif ($onlyGame == 'ac') {
            $gameString = '[assetto_corsa"]';
        } else {
            $gameString = '["acc","assetto_corsa"]';
        }

        if (!$leagueId) {
            $leagueId = Site::sgpLeagueId();
        }

        $this->cacheName = 'leagueSessions.' . $leagueId;

        $this->setClientToLeagueSessions();
        $this->buildQuery('leagueId', $leagueId);
        $this->buildQuery('games', $gameString);
        $this->buildQuery('limit', '12');
        $this->buildQuery('offset', '0');
        return $this->getResponse();
    }

    public function getUpcomingEvents($game = null, $leagueId = null)
    {
        return $this->getLeagueSessions($game, $leagueId);
    }

    public function getUserDetails($userId)
    {
        $this->cacheName = 'userDetails' . $userId;

        $this->setClientToUserViews($userId);
        return $this->getResponse();
    }

    public function getChampionshipDetails($champId)
    {
        $this->client = new \GuzzleHttp\Client(['base_uri' => "https://stg-api.simracing.gp/stg/tournament-view/$champId"]);

        return $this->getResponse();
    }
}
