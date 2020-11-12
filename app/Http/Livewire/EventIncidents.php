<?php

namespace App\Http\Livewire;

use App\DataProvider\DataProvider;
use App\Models\Incident;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EventIncidents extends Component
{
    public $event;
    public $driverList;
    public $statusList;

    public $penalty = "0";
    public $accusedId = "0";
    public $victimId = "0";
    public $timestamp = "";
    public $description = "";

    public $showDetails = false;
    public $accusedNameDispaly;
    public $victimNameDispaly;
    public $reportedNameDispaly;
    public $penaltyNameDispaly;
    public $timestampDispaly;
    public $descriptionDispaly;
    public $notesDispaly;
    public $statusDispaly;

    public function mount()
    {
        $this->event->load('incidents');
        $this->driverList = $this->event->getDriverList();
        $this->statusList = (new DataProvider)->getIncidentStatuses();
    }

    public function showDetails($incidentId)
    {
        $incident = Incident::find($incidentId);

        $this->accusedNameDispaly = $incident->accused->driver_name;
        $this->victimNameDispaly = $incident->victim->driver_name;
        $this->reportedNameDispaly = $incident->reportedBy->name;
        $this->penaltyNameDispaly = $incident->penalty->displayName;
        $this->timestampDispaly = $incident->timestamp;
        $this->descriptionDispaly = $incident->description;
        $this->notesDispaly = $incident->reviewers_notes;
        $this->statusDispaly = $this->statusList[$incident->status];
        $this->showDetails = true;
    }

    public function newIncident()
    {
        Incident::create([
            'accused_id' => $this->accusedId,
            'victim_id' => $this->victimId,
            'reported_by_id' => Auth::id(),
            'penalty_id' => $this->penalty,
            'event_id' => $this->event->id,
            'timestamp' => $this->timestamp,
            'description' => $this->description,
            'reviewers_notes' => 'Not reviewed',
            'status' => 0,
        ]);

        $this->resetAllFields();
    }

    public function resetAllFields()
    {
        $this->penalty = "1";
        $this->accusedId = "0";
        $this->victimId = "0";
        $this->timestamp = "";
        $this->description = "";
    }

    public function render()
    {
        return view('livewire.event-incidents');
    }
}
