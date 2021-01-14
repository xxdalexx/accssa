<?php

namespace App\Http\Livewire\Series;

use Livewire\Component;
use App\Models\SeriesLock;
use Illuminate\Support\Str;
use App\DataProvider\DataProvider;
use Illuminate\Support\Facades\Auth;
use App\Http\Guzzle\Sgp\RequestBuilders\AddDriverToEvent;
use App\Http\Guzzle\Sgp\RequestBuilders\CarForRegistration;
use App\Http\Guzzle\Sgp\RequestBuilders\RemoveDriverFromEvent;
use App\Http\Guzzle\Sgp\SgpPost;

class Registration extends Component
{
    public $series;
    public $cars;

    public $carInput = 'car0';

    protected $registered, $split, $car;


    public function mount()
    {
        $this->cars = (new DataProvider)->getGT3CarsForDropdown();

        if ($this->series->hasLockForUser(Auth::user())) {
            $this->carInput = 'car' . $this->series->getLockForUser(Auth::user())->car_id;
        }
    }

    public function register($makeChange = false)
    {
        $driver = Auth::user()->driver;
        $carId = Str::after($this->carInput, 'car');

        //Create Lock
        $lock = SeriesLock::updateOrCreate([
            'series_id' => $this->series->id,
            'driver_id' => $driver->id
        ]);
        if ($lock->wasRecentlyCreated) {
            $lock->split = $driver->calculateDriverScore()->currentSplit;
            $lock->car_id = (int) $carId;
            $lock->save();
        }

        //Go through each event and register
        $this->registerToEvents($carId, $lock, $driver);

        $this->series->refresh();
    }

    public function changeCar()
    {
        $carId = Str::after($this->carInput, 'car');
        $driver = Auth::user()->driver;

        //Update Series Lock
        $lock = $this->series->locks->firstWhere('driver_id', Auth::user()->driver->id);
        $lock->car_id = $carId;
        $lock->save();

        //here down should be changed to what sgp uses to change.
        $request = (new RemoveDriverFromEvent)->setDriver($driver);
        foreach ($this->series->sgpEventIds() as $eventId) {
            $response = (new SgpPost)->unregisterDriverFromEvent($eventId, $request);
        }

        $this->registerToEvents($carId, $lock, $driver);
    }

    protected function registerToEvents($carId, $lock, $driver)
    {
        $registrationCar = new CarForRegistration();
        $registrationCar->setCarId($carId);
        $registrationCar->setCarClass($lock->split);

        $registrationRequest = new AddDriverToEvent();
        $registrationRequest->setDriver($driver);
        $registrationRequest->setCar($registrationCar);

        foreach ($this->series->sgpEventIds() as $eventId) {
            $response = (new SgpPost)->addDriverToEvent($eventId, $registrationRequest);
        }
    }

    public function fillProtectedProps()
    {
        $this->registered = $this->series->hasLockForUser(Auth::user());
        if ($this->registered) {
            $lock = $this->series->getLockForUser(Auth::user());
            $this->split = $lock->split;
            $this->car = $this->cars['car' . $lock->car_id];
        }
    }

    public function render()
    {
        $this->fillProtectedProps();
        return view('livewire.series.registration')->with([
            'registered' => $this->registered,
            'split' => $this->split,
            'car' => $this->car
        ]);
    }
}
