<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserProfile extends Component
{
    public $user, $driver;
    public $driverNumber, $driverNumberSuccess = false;
    public $steamId, $steamIdSuccess = false;

    public function mount()
    {
        $this->user = Auth::user();
        $this->driver = $this->user->driver;
        $this->driverNumber = $this->driver->number;
        $this->steamId = $this->driver->steam_id;
    }

    public function hydrate()
    {
        $this->driverNumberSuccess = false;
        $this->steamIdSuccess = false;
    }

    public function changeDriverNumber()
    {
        $this->driver->number = $this->driverNumber;
        $this->driver->save();
        $this->driverNumberSuccess = true;
    }

    public function changeSteamId()
    {
        $this->driver->steam_id = $this->steamId;
        $this->driver->save();
        $this->steamIdSuccess = true;
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
