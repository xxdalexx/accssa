<?php


namespace App\Http\Guzzle\Sgp\Get;


use App\Http\Guzzle\Sgp\SgpApi;

class DriverResults extends SgpApi
{
    protected string $driverId;

    public function __construct(string $driverId)
    {
        $this->driverId = $driverId;

        parent::__construct();
    }

    protected function setClient(): self
    {
        $this->client = new \GuzzleHttp\Client(['base_uri' => "https://stg-api.simracing.gp/stg/driver-results/$this->driverId"]);

        return $this;
    }

    protected function setCacheKey(): self
    {
        $this->cacheName = 'driverResults.' . $this->driverId;
        return $this;
    }
}
