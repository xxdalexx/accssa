<?php

namespace App\Http\Livewire\Admin;

use App\Models\Driver;
use Livewire\Component;
use App\Models\SeriesLock;
use App\Http\Guzzle\Sgp\SgpBase;

class PreEventChecks extends Component
{
    public $sgpEventId, $seriesId = "0";
    public $driverEntriesForTable = [];

    public function pullData()
    {
        $data = (new SgpBase)->getPreEventDetails($this->sgpEventId);
        $selects = collect($data->driverEntries)->pluck('driverId');
        $driversFromDB = Driver::whereIn('sgp_id', $selects)->with('user')->get();
        $locks = SeriesLock::whereSeriesId($this->seriesId)->get();
        //dd($data);
        foreach ($data->driverEntries as $driver) {
            $registeredSplit = $driver->car->carClassId;
            //Build initial array.
            $this->driverEntriesForTable[$driver->driverId]['name'] = $driver->driverName;
            $this->driverEntriesForTable[$driver->driverId]['hasAccount'] = false;
            $this->driverEntriesForTable[$driver->driverId]['splitMatch'] = false;
            $this->driverEntriesForTable[$driver->driverId]['haveDiscordId'] = false;

            //Start Checking
            if ($dbEntry = $driversFromDB->where('sgp_id', $driver->driverId)->first()) {
                if ($dbEntry->user()->exists()) {
                    $this->driverEntriesForTable[$driver->driverId]['hasAccount'] = true;
                }
                if ($dbEntry->discord_user_id) {
                    $this->driverEntriesForTable[$driver->driverId]['haveDiscordId'] = true;
                }
                //See if split matches if there is a series selected
                if ($this->seriesId) {
                    if ($lock = $locks->where('driver_id', $dbEntry->id)->first()) {
                        $this->driverEntriesForTable[$driver->driverId]['splitMatch'] = (substr($lock->split, 0, 3) == $registeredSplit);
                        if ($driver->driverName == "Paul Cantea") {
                            dd($this->driverEntriesForTable[$driver->driverId], $lock->split, $registeredSplit);
                        }
                    } else {
                        $this->driverEntriesForTable[$driver->driverId]['splitMatch'] = (substr($dbEntry->getCurrentSplitAttribute(), 0, 3) == $registeredSplit);
                    }
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.pre-event-checks');
    }
}
