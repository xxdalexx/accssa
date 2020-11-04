<?php

namespace App\Http\Livewire\Admin;

use App\Models\Driver;
use App\Models\Invite;
use Livewire\Component;

class Drivers extends Component
{
    public $searchString;
    public $importString;
    public $importSuccess;
    public $importedDriverName;
    public $sortBy = 'driver_name';

    public function hydrate()
    {
        $this->importSuccess = false;
    }

    public function calculateScore($driverId)
    {
        $driver = Driver::find($driverId);
        $driver->calculateDriverScore();
    }

    public function genInvite($driverId)
    {
        Invite::generate($driverId);
    }

    public function import()
    {
        $newDriver = Driver::importFromSgp($this->importString);
        $this->importedDriverName = $newDriver->driver_name;
        $this->importString = '';
        $this->importSuccess = true;
    }

    public function render()
    {
        return view('livewire.admin.drivers')
            ->withDrivers(
                Driver::where('driver_name', 'LIKE', '%' . $this->searchString . '%')
                    ->orderBy($this->sortBy)
                    ->get()
            );
    }
}
