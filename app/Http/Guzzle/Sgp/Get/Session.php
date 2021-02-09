<?php


namespace App\Http\Guzzle\Sgp\Get;


use App\Http\Guzzle\Sgp\SgpApi;

class Session extends SgpApi
{
    protected String $eventId;

    public function forEvent(string $eventId)
    {
        $this->eventId = $eventId;
        return $this;
    }

    protected function setClient(): SgpApi
    {
        $this->client =
            new \GuzzleHttp\Client(['base_uri' => "https://stg-api.simracing.gp/stg/sessions/$this->eventId"]);

        return $this;
    }

    protected function setCacheKey(): SgpApi
    {
        return $this;
    }
}
