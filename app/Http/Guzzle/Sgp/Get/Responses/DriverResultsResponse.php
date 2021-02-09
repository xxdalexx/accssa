<?php


namespace App\Http\Guzzle\Sgp\Get\Responses;


use App\Http\Guzzle\Sgp\Get\DriverResults;

class DriverResultsResponse
{
    protected $rawResponse;

    public function forDriver(string $driverId)
    {
        $this->rawResponse = app(DriverResults::class)
            ->forDriver($driverId)
            ->get();
        return $this;
    }

    public function getRawResponse()
    {
        return $this->rawResponse;
    }
}
