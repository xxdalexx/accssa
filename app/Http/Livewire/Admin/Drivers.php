<?php

namespace App\Http\Livewire\Admin;

use App\Models\Driver;
use App\Models\Invite;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use NotificationChannels\Discord\Discord;

class Drivers extends Component
{
    public $searchString;
    public $importString;
    public $importSuccess;
    public $importedDriverName;
    public $sortBy = 'driver_name';
    public $snowflakes = [];
    public $apiFailed = false;

    public function mount()
    {
        $ids = Driver::pluck('id');
        foreach ($ids as $id) {
            $this->snowflakes['driver' . $id] = '';
        }
    }

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
        $driver = Driver::find($driverId);
        $discord = $this->snowflakes['driver' . $driverId];
        $invite = Invite::generate($driverId);

        if (!empty($discord)) {
            $driver->discord_user_id = $discord;
            $driver->discord_private_channel_id = app(Discord::class)->getPrivateChannel($discord);
            $driver->save();

            $inviteURL = route('invite.show', $invite);

            //formatting is off on purpose.
            $driver->sendDiscordDM('Hey ' . $driver->driver_name . ', ' . Auth::user()->name . ' has added you to the **ACCSSA League Tracker**.
All you need to do is visit '. $inviteURL . ' to complete your registration and gain access.
_This is an automated message, send Dale a message if you have any issues._');
        }
    }

    public function import()
    {
        $newDriver = Driver::importFromSgp($this->importString);
        //api failed
        if (!$newDriver) {
            $this->apiFailed = true;
            return;
        }
        $this->importedDriverName = $newDriver->driver_name;
        $this->importString = '';
        $this->importSuccess = true;
        $this->searchString = $newDriver->driver_name;
        $this->mount();
    }

    public function render()
    {
        $drivers = Driver::where('driver_name', 'LIKE', '%' . $this->searchString . '%')
                    ->orderBy($this->sortBy)
                    ->get();

        return view('livewire.admin.drivers')
            ->with(['drivers' => $drivers]);
    }
}
