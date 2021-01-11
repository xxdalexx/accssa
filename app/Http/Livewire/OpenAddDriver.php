<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Guzzle\Sgp\SgpBase;
use App\Http\Guzzle\Sgp\SgpPost;
use App\Http\Guzzle\Sgp\RequestBuilders\AddDriverToEvent;
use App\Http\Guzzle\Sgp\RequestBuilders\AddDriverToChampionship;
use App\Http\Guzzle\Sgp\RequestBuilders\CarForRegistration;

class OpenAddDriver extends Component
{
    public $leagueId, $sgpEventId, $sgpChampionshipId, $carId, $carClass, $driverId;
    public $type = 'Event';
    protected $addResponse;
    public $hasCarClass = false;

    public $upcomingEvents, $upcomingChamps, $memberList, $carClassList, $carList;

    public $leagueList = [
        'ikG1uiyY6vvTGCTAL486M' => 'ACCSS Americas',
        'VVyq-AUsfsLZ8yExCO-S9' => 'ACCSS',
        'yL-fZ-6YVsQZBDYLS2F-U' => 'GC',
        '1772eUSJzLnh64svJwv7f' => 'Pit Crew'
    ];

    public function mount()
    {
        $this->leagueId = 'ikG1uiyY6vvTGCTAL486M';
        $this->fillEvents();
        $this->fillMemberList();
    }

    public function updatedSgpEventId()
    {
        $this->fillFromEventInfo();
    }

    public function updatedSgpChampionshipId()
    {
        $this->fillFromChampInfo();
    }

    public function updatedLeagueId()
    {
        if ($this->type == 'Event') {
            $this->fillEvents();
        } else {
            $this->fillChampionships();
        }
        $this->fillMemberList();
    }

    public function updatedType()
    {
        if ($this->type == 'Event') {
            $this->fillEvents();
        } else {
            $this->fillChampionships();
        }
    }

    public function addDriver()
    {
        $method = 'addDriverTo' . $this->type;
        return $this->$method();
    }

    public function addDriverToEvent()
    {
        $registrationCar = new CarForRegistration();
        $registrationCar->setCarId($this->carId);
        $registrationCar->setCarClass($this->carClass);

        $registrationRequest = new AddDriverToEvent();
        $registrationRequest->setDriverId($this->driverId);
        $registrationRequest->setCar($registrationCar);

        $this->addResponse = (new SgpPost)->addDriverToEvent($this->sgpEventId, $registrationRequest);
    }

    public function addDriverToChampionship()
    {
        $request = new addDriverToChampionship();
        $request->setDriverId($this->driverId);
        $request->setChampionshipId($this->sgpChampionshipId);
        $request->setCarId($this->carId);

        if ($this->hasCarClass) {
            $request->setCarClass($this->carClass);
        }

        $this->addResponse = (new SgpPost)->addDriverToChampionship($request);
    }

    protected function fillChampionships()
    {
        $upcomingChamps = (new SgpBase)->getUpcomingChampionships('acc', $this->leagueId);
        $this->upcomingChamps = [];

        if (!$upcomingChamps) {
            $this->apiFailed = true;
            return;
        }

        foreach ($upcomingChamps as $champ) {
            $listEntry = [];
            $listEntry['id'] = $champ->id;
            $listEntry['name'] = $champ->name;
            $this->upcomingChamps[] = $listEntry;
        }
        $this->sgpChampionshipId = $this->upcomingChamps[0]['id'];
        $this->fillFromChampInfo();
    }

    protected function fillEvents()
    {
        $upcomingEvents = (new SgpBase)->getUpcomingEvents('acc', $this->leagueId);
        $this->upcomingEvents = [];

        if (!$upcomingEvents) {
            $this->apiFailed = true;
            return;
        }

        foreach ($upcomingEvents as $event) {
            if (is_null($event->tournamentId)) {
                $listEntry = [];
                $listEntry['id'] = $event->id;
                $listEntry['name'] = $event->sessionName;
                $this->upcomingEvents[] = $listEntry;
            }
        }
        if (array_key_exists(0, $this->upcomingEvents)) {
            $this->sgpEventId = $this->upcomingEvents[0]['id'];
            $this->fillFromEventInfo();
        } else {
            $this->sgpEventId = false;
        }
    }

    protected function fillMemberList()
    {
        $response = (new SgpBase)->getLeagueMemberList($this->leagueId);
        $this->memberList = [];

        foreach ($response->members as $id => $member) {
            $listEntry = [];
            $listEntry['id'] = $id;
            $listEntry['name'] = $member->name;
            $this->memberList[] = $listEntry;
        }
        $this->driverId = $this->memberList[0]['id'];
    }

    protected function fillFromChampInfo()
    {
        $response = (new SgpBase)->getChampionshipDetails($this->sgpChampionshipId);
        $this->carClassList = [];
        $this->carList = [];

        if (isset($response->gameSettings->carClasses) && count($response->gameSettings->carClasses) > 0) {
            $this->hasCarClass = true;

            foreach ($response->gameSettings->carClasses as $class) {
                $listEntry = [];
                $listEntry['id'] = $class->id;
                $listEntry['name'] = $class->name;
                $this->carClassList[] = $listEntry;
            }
            $this->carClass = $this->carClassList[0]['id'];

        } else {
            $this->hasCarClass = false;
        }

        foreach ($response->gameSettings->cars as $car) {
            $listEntry = [];
            $listEntry['id'] = $car->id;
            $listEntry['name'] = $car->name;
            $this->carList[] = $listEntry;
        }
        $this->carId = $this->carList[0]['id'];

    }

    protected function fillFromEventInfo()
    {
        $response = (new SgpBase)->getPreEventDetails($this->sgpEventId);
        $this->carClassList = [];
        $this->carList = [];

        if (count($response->carClasses) > 0) {
            $this->hasCarClass = true;

            foreach ($response->carClasses as $class) {
                $listEntry = [];
                $listEntry['id'] = $class->id;
                $listEntry['name'] = $class->name;
                $this->carClassList[] = $listEntry;
            }
            $this->carClass = $this->carClassList[0]['id'];

        } else {
            $this->hasCarClass = false;
        }


        foreach ($response->cars as $car) {
            $listEntry = [];
            $listEntry['id'] = $car->id;
            $listEntry['name'] = $car->name;
            $this->carList[] = $listEntry;
        }
        $this->carId = $this->carList[0]['id'];
    }

    public function render()
    {
        return view('livewire.open-add-driver')->with([
            'addResponse' => $this->addResponse
        ]);
    }
}
