<?php

namespace App\Http\Livewire\Admin;

use App\Models\Series;
use Livewire\Component;
use App\Models\SeriesLock;
use Illuminate\Support\Str;

class SeriesLocks extends Component
{
    public $seriesId;
    public $locks;

    public function mount()
    {
        $this->seriesId = Series::pluck('id')->first();
        $this->setLocks();
    }

    public function updatedSeriesId()
    {
        $this->setLocks();
    }

    protected function setLocks()
    {
        $this->locks = [];
        $locks = SeriesLock::whereSeriesId($this->seriesId)->with('driver')->get()->sortBy('driver.driver_name');
        foreach ($locks as $lock) {
            $row = [];
            $row['driver_name'] = $lock->driver->driver_name;
            $row['split'] = $lock->split;
            $this->locks['lock' . $lock->id] = $row;
        }
    }

    public function overrideSplit($key)
    {
        $lockId = (int) Str::after($key, 'lock');
        $lock = SeriesLock::find($lockId);
        $lock->overrideSplit($this->locks[$key]['split']);
        $this->locks[$key]['success'] = true;
    }

    public function render()
    {
        return view('livewire.admin.series-locks');
    }
}
