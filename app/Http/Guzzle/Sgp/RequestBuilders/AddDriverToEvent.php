<?php

namespace App\Http\Guzzle\Sgp\RequestBuilders;

use App\DataProvider\DataProvider;
use App\Models\Driver;
use App\Models\Site;

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
        $payload['leagueId'] = Site::sgpLeagueId();
        $payload['listType'] = "SingleEvent";
        $payload['entry']['driverId'] = $this->driverId;
        $payload['entry']['car'] = $this->car->getRequestArray();
        $payload['type'] = "REGULAR";

        $request['payload'] = $payload;

        return $request;
    }

    public function getRequestJson()
    {
        $request = $this->getRequestArray();
        return prettyJson(collect($request));
    }

}

//{
//    "payload": {
//        "leagueId": "ikG1uiyY6vvTGCTAL486M",
//        "listType": "SingleEvent",
//        "entry": {
//            "driverId": "SXs33IH-ZDSa6A2hUzKU_",
//            "car": {
//                "model": "16",
//                "skin": "default",
//                "carClassId": "AM"
//            },
//         "type": "REGULAR"
//        }
//    }
//}

// {
//     "driverId": "SXs33IH-ZDSa6A2hUzKU_",
//     "car": {
//         "model": "23",
//         "skin": "default",
//         "carClassId": "GT3"
//     }
// }
