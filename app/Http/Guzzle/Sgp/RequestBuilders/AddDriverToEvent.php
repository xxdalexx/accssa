<?php

namespace App\Http\Guzzle\Sgp\RequestBuilders;

use App\DataProvider\DataProvider;
use App\Models\Driver;

class AddDriverToEvent
{
    protected $driverId;
    protected Driver $driver;
    protected Bool $carClassRequired = false;
    protected CarForRegistration $car;

    public function __construct($driver = null, $car = null)
    {
        if ($driver) {
            $this->setDriver($driver);
        }

        if ($car) {
            $this->setCar($car);
        }
    }

    public function setDriver(Driver $driver)
    {
        $this->driver = $driver;
        return $this->setDriverId($driver->sgp_id);
    }

    public function setDriverId(string $sgpDriverId)
    {
        $this->driverId = $sgpDriverId;
        return $this;
    }

    public function setCar(CarForRegistration $car)
    {
        $this->car = $car;
        return $this;
    }

    public function getRequestArray()
    {
        $request['driverId'] = $this->driverId;
        $request['car'] = $this->car->getRequestArray();

        return $request;
    }

    public function getRequestJson()
    {
        $request = $this->getRequestArray();
        return prettyJson(collect($request));
    }

}

// {
//     "driverId": "SXs33IH-ZDSa6A2hUzKU_",
//     "car": {
//         "model": "23",
//         "skin": "default",
//         "carClassId": "GT3"
//     }
// }
