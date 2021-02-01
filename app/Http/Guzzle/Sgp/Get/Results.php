<?php

namespace App\Http\Guzzle\Sgp\Get;

use App\Http\Guzzle\Sgp\SgpApi;

class Results extends SgpApi
{
    protected string $eventId;

    public function __construct(string $eventId)
    {
        $this->eventId = $eventId;

        parent::__construct();
    }

    public function setEventId(string $eventId)
    {
        $this->eventId = $eventId;
    }

    protected function setClient()
    {
        $this->client = new \GuzzleHttp\Client(['base_uri' => "https://stg-api.simracing.gp/stg/results/$this->eventId"]);

        return $this;
    }

    protected function setCacheKey()
    {
        $this->cacheName = 'eventResults.' . $this->eventId;
    }

}
