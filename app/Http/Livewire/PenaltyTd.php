<?php

namespace App\Http\Livewire;

use App\Models\EventEntry;
use Livewire\Component;

class PenaltyTd extends Component
{
    public $eventEntryId;
    public $points;

    public function add()
    {
        $eventEntry = EventEntry::find($this->eventEntryId);
        $eventEntry->penalty_points += 1;
        $eventEntry->save();
        $eventEntry->event->recalculatePoints();
        $this->points = $eventEntry->penalty_points;
    }

    public function subtract()
    {
        $eventEntry = EventEntry::find($this->eventEntryId);
        $eventEntry->penalty_points -= 1;
        $eventEntry->save();
        $eventEntry->event->recalculatePoints();
        $this->points = $eventEntry->penalty_points;
    }

    public function render()
    {
        return view('livewire.penalty-td');
    }
}
