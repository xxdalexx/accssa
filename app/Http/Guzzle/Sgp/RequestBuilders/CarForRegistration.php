<?php

namespace App\Http\Guzzle\Sgp\RequestBuilders;

use App\DataProvider\DataProvider;

class CarForRegistration
{
    protected string $model;
    protected string $skin, $carClassId;
    protected bool $carClassRequired = false;

    public function __construct($id = null, $class = null)
    {
        $this->skin = "default";

        if ($id) {
            $this->setcarId($id);
        }

        if ($class) {
            $this->setCarClass($class);
        }
    }

    public function requireCarClass($required = true)
    {
        $this->carClassRequired = $required;
        return $this;
    }

    public function getCarClassRequired()
    {
        return $this->carClassRequired;
    }

    public function setCarId(string $id)
    {
        return $this->setModel($id);
    }

    public function setModel(string $modelId)
    {
        $this->model = $modelId;
        return $this;
    }

    public function setCarClass(string $carClass)
    {
        if ($carClass == 'Silver') {
            $carClass = 'Sil';
        }

        $this->carClassId = $carClass;
        $this->carClassRequired = true;

        return $this;
    }

    public function getRequestArray()
    {
        $car['model'] = $this->model;
        $car['skin'] = $this->skin;

        if ($this->carClassRequired) {
            $car['carClassId'] = $this->carClassId;
        }

        return $car;
    }

    public function getRequestJson()
    {
        $car = $this->getRequestArray();
        return prettyJson(collect($car));
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
