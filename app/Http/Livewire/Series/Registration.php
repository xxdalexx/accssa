<?php

namespace App\Http\Livewire\Series;

use Livewire\Component;
use App\Models\SeriesLock;
use Illuminate\Support\Str;
use App\DataProvider\DataProvider;
use Illuminate\Support\Facades\Auth;
use App\Http\Guzzle\Sgp\RequestBuilders\AddDriverToEvent;
use App\Http\Guzzle\Sgp\RequestBuilders\CarForRegistration;
use App\Http\Guzzle\Sgp\SgpPost;

class Registration extends Component
{
    public $series;
    public $cars;

    public $carInput = 'car0';

    protected $registered, $split;

    public function register()
    {
        $driver = Auth::user()->driver;
        $carId = Str::after($this->carInput, 'car');

        //Create Lock
        $lock = SeriesLock::firstOrCreate([
            'series_id' => $this->series->id,
            'driver_id' => $driver->id
        ]);
        if ($lock->wasRecentlyCreated) {
            $lock->split = $driver->calculateDriverScore()->currentSplit;
            $lock->car_id = (int) $carId;
            $lock->save();
        }

        //Go through each event and register
        $registrationCar = new CarForRegistration();
        $registrationCar->setCarId($carId);
        $registrationCar->setCarClass($lock->split);

        $registrationRequest = new AddDriverToEvent();
        $registrationRequest->setDriver($driver);
        $registrationRequest->setCar($registrationCar);

        foreach ($this->series->sgpEventIds() as $eventId) {
            $response = (new SgpPost)->addDriverToEvent($eventId, $registrationRequest);
        }

        $this->series->refresh();
    }

    public function mount()
    {
        $this->cars = (new DataProvider)->getGT3CarsForDropdown();
    }

    public function fillProtectedProps()
    {
        $this->registered = $this->series->hasLockForUser(Auth::user());
        if ($this->registered) {
            $this->split = $this->series->getLockForUser(Auth::user())->split;
        }
    }

    public function render()
    {
        $this->fillProtectedProps();
        return view('livewire.series.registration')->with([
            'registered' => $this->registered,
            'split' => $this->split
        ]);
    }
}
