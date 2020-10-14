<?php

namespace App\Http\Guzzle\Sgp;

use App\Http\Guzzle\GuzzleBase;
use App\Http\Guzzle\Sgp\Cleaners\EventResultsCleaner;

class SgpBase extends GuzzleBase
{
    public function __construct()
    {
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IlNYczMzSUgtWkRTYTZBMmhVektVXyIsInN0ZWFtSWQiOiI3NjU2MTE5ODAzMjcwMTY2MyIsImlhdCI6MTYwMTg5NjAwMywiZXhwIjoxNjAyMzI4MDAzfQ.tXnhxSRBVnY3gAFJ_N3EwWapZ3sOoUBn6pru4xOODG4';
        $this->params = [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
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

    protected function setClientToLeagueSessions()
    {
        $this->client = new \GuzzleHttp\Client(['base_uri' => "https://stg-api.simracing.gp/stg/session-views/league-sessions"]);

        return $this;
    }

    public function getEventResults(string $eventId)
    {
        $this->setClientToResults($eventId);
        $cleaner = new EventResultsCleaner($this->getResponse());
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
