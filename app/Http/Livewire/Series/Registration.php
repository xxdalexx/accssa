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

    public function register()
    {
        $carId = Str::after($this->carInput, 'car');

        $handler = new RegistrationHandler($this->series);
        $handler->register($carId);

        $this->series->refresh();
    }

    public function changeCar()
    {
        $carId = Str::after($this->carInput, 'car');

        $handler = new RegistrationHandler($this->series);
        $handler->changeCar($carId);

        $this->series->refresh();
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
