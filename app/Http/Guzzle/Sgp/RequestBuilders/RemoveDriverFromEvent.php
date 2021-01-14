<?php


namespace App\Http\Guzzle\Sgp\RequestBuilders;

use App\Models\Driver;

class RemoveDriverFromEvent
{
    protected $driverId;

    public function setDriver(Driver $driver)
    {
        return $this->setDriverId($driver->sgp_id);
    }

    public function setDriverId(string $sgpDriverId)
    {
        $this->driverId = $sgpDriverId;
        return $this;
    }

    public function getRequestArray()
    {
        $request['driverId'] = $this->driverId;

        return $request;
    }

    public function getRequestJson()
    {
        $request = $this->getRequestArray();
        return prettyJson(collect($request));
    }
}
