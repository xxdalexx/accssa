<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Livewire\Component;

class EventEditor extends Component
{
    public $event;
    public $nameInput, $replayInput;
    public $showImport = false, $minLap = 20;

    public function mount()
    {
        $this->nameInput = $this->event->session_name;
        $this->replayInput = $this->event->replay_url;
    }

    public function updateName()
    {
        $this->event->session_name = $this->nameInput;
        $this->event->save();
        return redirect($this->event->link());
    }

    public function updateReplay()
    {
        $this->event->replay_url = $this->replayInput;
        $this->event->save();
        return redirect($this->event->link());
    }

    public function importResults()
    {
        Event::build(
            $this->event->session_id_sgp,
            $this->event->series->id,
            $this->minLap
        );

        return redirect($this->event->link());
    }

    public function render()
    {
        return view('livewire.event-editor');
    }
}
