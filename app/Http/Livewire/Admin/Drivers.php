<?php

namespace App\Http\Livewire\Admin;

use App\Models\Driver;
use App\Models\Invite;
use Livewire\Component;

class Drivers extends Component
{
    public $searchString;

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
        dd('import');
    }

    public function render()
    {
        return view('livewire.admin.drivers')
            ->withDrivers(
                Driver::where('driver_name', 'LIKE', '%' . $this->searchString . '%')
                    ->orderBy('driver_score')
                    ->get()
            );
    }
}
