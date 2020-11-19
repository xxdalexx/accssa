<?php

namespace App\Http\Livewire\Admin;

use App\Models\Event;
use Livewire\Component;

class ImportEvent extends Component
{
    public $seriesId;
    public $sgpEventId;
    public $minLaps = 20;

    public function submitForm()
    {
        $event = Event::build($this->sgpEventId, $this->seriesId, $this->minLaps);
        return redirect($event->link());
    }

    public function render()
    {
        return view('livewire.admin.import-event');
    }
}
