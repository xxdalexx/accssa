<?php


namespace Tests\Mocks;


use App\Http\Guzzle\Sgp\Get\DriverResults;

class SgpDriverResultMock extends DriverResults
{
    public function __construct(string $driverId)
    {

    }

    public function get()
    {
        return 'faked';
    }
}
