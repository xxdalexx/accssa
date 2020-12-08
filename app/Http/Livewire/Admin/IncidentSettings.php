<?php

namespace App\Http\Livewire\Admin;

use App\Models\Penalty;
use Livewire\Component;

class IncidentSettings extends Component
{
    public $newPenalty = [
        'description' => '',
        'points' => '',
        'protected' => false
    ];

    public function createPenalty()
    {
        $penalty = Penalty::create([
            'description' => $this->newPenalty['description'],
            'points' => $this->newPenalty['points'],
            'protected' => $this->newPenalty['protected']
        ]);
    }

    public function render()
    {
        return view('livewire.admin.incident-settings')->with([
            'penalties' => Penalty::all()
        ]);
    }
}
