<?php


namespace App\Http\Guzzle\Sgp\Get;


use App\Http\Guzzle\Sgp\SgpApi;

class DriverResults extends SgpApi
{
    protected string $driverId;

    public function forDriver(string $driverId)
    {
        $this->driverId = $driverId;
        return $this;
    }

    public function setDriverId(string $driverId): DriverResults
    {
        $this->driverId = $driverId;

        return $this;
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
