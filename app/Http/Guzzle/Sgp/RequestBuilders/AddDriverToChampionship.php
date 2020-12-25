<?php

namespace App\Http\Guzzle\Sgp\RequestBuilders;

class AddDriverToChampionship
{
    protected $championshipId; //aggregateId
    protected $driverId;
    protected $carId;
    protected $carClass;
    protected $hasCarClass = false;

    public function setChampionshipId($champId)
    {
        $this->championshipId = $champId;
        return $this;
    }

    public function setDriverId($driverId)
    {
        $this->driverId = $driverId;
        return $this;
    }

    public function setCarId($id)
    {
        $this->carId = $id;
        return $this;
    }

    public function setCarClass($class)
    {
        $this->carClass = $class;
        $this->hasCarClass = true;
        return $this;
    }

    public function getRequestArray()
    {
        $request = [];

        $request['aggregateId'] = $this->championshipId;
        $request['aggregateVersion'] = 5;
        $request['command']['type'] = 'JoinTournament';
        $request['command']['userId'] = $this->driverId;
        $request['command']['carModelId'] = $this->carId;
        $request['command']['carSkinId'] = 'default';
        if ($this->hasCarClass) {
            $request['command']['carClassId'] = $this->carClass;
        }

        return $request;
    }

    public function getRequestJson()
    {
        $request = $this->getRequestArray();
        return prettyJson(collect($request));
    }
}
