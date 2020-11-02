<?php

namespace App\Http\Livewire\Admin;

use App\Models\Driver;
use Livewire\Component;

class Drivers extends Component
{
    public function calculateScore($driverId)
    {
        $driver = Driver::find($driverId);
        $driver->calculateDriverScore();
    }

    public function render()
    {
        return view('livewire.admin.drivers')
            ->withDrivers(Driver::orderBy('driver_name')->get());
    }
}
