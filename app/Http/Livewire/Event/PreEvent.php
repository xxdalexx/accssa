<?php

namespace App\Http\Livewire\Event;

use App\Models\Event;
use Livewire\Component;

class PreEvent extends Component
{
    public $event;

    public function importResults()
    {
        Event::build(
            $this->event->session_id_sgp,
            $this->event->series->id,
            0
        );

        return redirect($this->event->link());
    }

    public function render()
    {
        return view('livewire.event.pre-event');
    }
}
