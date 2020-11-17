<?php

namespace App\Http\Livewire;

use App\DataProvider\DataProvider;
use App\Models\EventEntry;
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
    public $firstLap = "0";

    public $showDetails = false;
    public $accusedNameDisplay;
    public $victimNameDisplay;
    public $reportedNameDisplay;
    public $penaltyNameDisplay;
    public $timestampDisplay;
    public $descriptionDisplay;
    public $notesDisplay;
    public $statusDisplay;
    public $displayedStatusId;
    public $displayedIncidentId;
    public $appliedDisplay;
    public $firstLapDisplay;
    public $statusChangeSuccess = false;

    public function mount()
    {
        $this->event->load('incidents');
        $this->driverList = $this->event->getDriverList();
        $this->statusList = (new DataProvider)->getIncidentStatuses();
    }

    public function hydrate()
    {
        $this->statusChangeSuccess = false;
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    }

    public function showDetails($incidentId)
    {
        $incident = Incident::find($incidentId);

        $this->accusedNameDisplay = $incident->accused->driver_name;
        $this->victimNameDisplay = $incident->victim->driver_name;
        $this->reportedNameDisplay = $incident->reportedBy->name;
        $this->penaltyNameDisplay = $incident->penalty->displayName;
        $this->timestampDisplay = $incident->timestamp;
        $this->descriptionDisplay = $incident->description;
        $this->notesDisplay = $incident->reviewers_notes;
        $this->statusDisplay = $this->statusList[$incident->status];
        $this->appliedDisplay = $incident->penalty_applied;
        $this->firstLapDisplay = $incident->first_lap;
        $this->displayedStatusId = $incident->status;
        $this->displayedIncidentId = $incident->id;
        $this->showDetails = true;
    }

    public function deleteIncident()
    {
        $incident = Incident::find($this->displayedIncidentId);
        $incident->delete();
        $this->event->refresh();
        $this->showDetails = false;
    }

    public function updateStatusOfDisplayed()
    {
        $incident = Incident::find($this->displayedIncidentId);
        $incident->status = $this->displayedStatusId;
        if ($incident->save()) {
            $this->statusChangeSuccess = true;
        }
        $this->event->refresh();
    }

    public function requestReview()
    {
        $incident = Incident::find($this->displayedIncidentId);
        $incident->status = 2;
        $incident->save();
        $this->displayedStatusId = 2;
        $this->statusDisplay = $this->statusList[2];
        $this->event->refresh();
    }

    public function acceptPenalty()
    {
        $this->applyPenalty(true);
    }

    public function applyPenalty($userAccepted = false)
    {
        $incident = Incident::find($this->displayedIncidentId);
        $eventEntry = EventEntry::where(['event_id' => $incident->event_id, 'driver_id' => $incident->accused_id])->first();

        $eventEntry->penalty_points += $incident->penalty->points;
        if ($incident->first_lap) {
            $eventEntry->penalty_points += $incident->penalty->points; //Apply again if first lap
        }
        $eventEntry->save();

        $incident->penalty_applied = true;
        if ($userAccepted) {
            $incident->status = 1;
        }
        $incident->save();

        $this->event->refresh();
        $this->showDetails($incident->id);
    }

    public function newIncident()
    {
        $incident = Incident::create([
            'accused_id' => $this->accusedId,
            'victim_id' => $this->victimId,
            'reported_by_id' => Auth::id(),
            'penalty_id' => $this->penalty,
            'event_id' => $this->event->id,
            'timestamp' => $this->timestamp,
            'description' => $this->description,
            'reviewers_notes' => 'Not reviewed',
            'first_lap' => $this->firstLap,
            'status' => 0,
        ]);

        //Self Reported
        if (Auth::user()->driver->id == (int) $this->accusedId) {
            $incident->penalty_applied = true;
            $incident->status = 1; //Accepted by Accused
            $incident->save();

            $eventEntry = EventEntry::where(['event_id' => $incident->event_id, 'driver_id' => $incident->accused_id])->first();
            $eventEntry->penalty_points += $incident->penalty->points;
            if ($incident->first_lap) {
                $eventEntry->penalty_points += $incident->penalty->points; //Apply again if first lap
            }
            $eventEntry->save();
        }

        $this->resetAllFields();
        $this->event->refresh();
    }

    public function resetAllFields()
    {
        $this->penalty = "1";
        $this->accusedId = "0";
        $this->victimId = "0";
        $this->timestamp = "";
        $this->description = "";
        $this->firstLap = "0";
    }

    public function render()
    {
        return view('livewire.event-incidents');
    }
}
