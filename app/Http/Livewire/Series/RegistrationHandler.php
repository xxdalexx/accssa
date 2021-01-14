<?php


namespace App\Http\Livewire\Series;

use App\Http\Guzzle\Sgp\RequestBuilders\AddDriverToEvent;
use App\Http\Guzzle\Sgp\RequestBuilders\CarForRegistration;
use App\Http\Guzzle\Sgp\SgpPost;
use App\Models\Driver;
use App\Models\Series;
use App\Models\SeriesLock;
use Illuminate\Support\Facades\Auth;

class RegistrationHandler
{
    protected Driver $driver;
    protected Series $series;
    protected SeriesLock $lock;
    protected CarForRegistration $car;
    protected AddDriverToEvent $addRequest;

    use RegistrationHandlerGettersSetters;

    public function __construct($series)
    {
        $this->setSeries($series);
        $this->driver = Auth::driver();
    }

    public function register($carId)
    {
        $this->createLock($carId);
        $this->car = new CarForRegistration($carId, $this->lock->split);
        $this->addRequest = new AddDriverToEvent($this->driver, $this->car);
        $this->sendRegistrationToSGP();
    }

    public function changeCar($carId)
    {
        $this->overrideLockCarId($carId);
        $this->car = new CarForRegistration($carId, $this->lock->split);
        $this->addRequest = new AddDriverToEvent($this->driver, $this->car);
        $this->sendRegistrationToSGP();
    }

    public function changeSplit($split)
    {
        $this->overrideLockSplit($split);
        $this->car = new CarForRegistration($this->lock->car_id, $split);
        $this->addRequest = new AddDriverToEvent($this->driver, $this->car);
        $this->sendRegistrationToSGP();
    }

    protected function createLock($carId)
    {
        $lock = $this->assignLock();

        $lock->split = $this->driver->calculateDriverScore()->currentSplit;
        $lock->car_id = (int) $carId;
        $lock->save();

        $this->lock = $lock;
    }

    protected function assignLock()
    {
        return SeriesLock::firstOrCreate([
            'series_id' => $this->series->id,
            'driver_id' => $this->driver->id
        ]);
    }

    protected function overrideLockSplit($split)
    {
        $this->lock = $this->assignLock();
        $this->lock->split = $split;
        $this->lock->save();
    }

    protected function overrideLockCarId($carId)
    {
        $this->lock = $this->assignLock();
        $this->lock->car_id = $carId;
        $this->lock->save();
    }

    protected function sendRegistrationToSGP()
    {
        foreach ($this->series->sgpEventIds() as $eventId) {
            $response = (new SgpPost)->addDriverToEvent($eventId, $this->addRequest);
        }
    }
}
