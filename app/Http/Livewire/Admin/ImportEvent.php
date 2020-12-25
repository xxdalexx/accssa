<?php

namespace App\Http\Livewire\Admin;

use App\Models\Event;
use Livewire\Component;

class ImportEvent extends Component
{
    public $seriesId;
    public $sgpEventId;
    public $hasResults = 0;
    public $minLaps = 20;
    public $failed = false;

    public function submitForm()
    {
        if ($this->hasResults) {
            $event = Event::build($this->sgpEventId, $this->seriesId, $this->minLaps);
        } else {
            $event = Event::buildPreResults($this->sgpEventId, $this->seriesId);
        }

        //api call failed
        if (!$event) {
            $this->failed = true;
            return;
        }

        return redirect($event->link());
    }

    public function render()
    {
        return view('livewire.admin.import-event');
    }
}
