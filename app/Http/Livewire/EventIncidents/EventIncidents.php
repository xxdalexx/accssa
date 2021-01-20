<?php

namespace App\Http\Livewire\EventIncidents;

use Livewire\Component;
use App\Models\Incident;
use App\Models\EventEntry;
use Illuminate\Support\Str;
use App\DataProvider\DataProvider;
use Illuminate\Support\Facades\Auth;

class EventIncidents extends Component
{
    use ReportForm;

    public $event;
    public $driverList;
    public $statusList;

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
    public $displayedPenaltyId;
    public $displayedReviewerNotes;
    public $appliedDisplay;
    public $firstLapDisplay;
    public $statusChangeSuccess = false;
    public $reviewNotesUpdateSuccess = false;
    public $penaltyChangeSuccess = false;

    public function mount()
    {
        $this->event->load('incidents');
        $this->driverList = $this->event->getDriverList();
        $this->statusList = (new DataProvider)->getIncidentStatuses();
    }

    public function hydrate()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->statusChangeSuccess = false;
        $this->reviewNotesUpdateSuccess = false;
        $this->penaltyChangeSuccess = false;
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
        $this->displayedReviewerNotes = $incident->reviewers_notes;
        $this->statusDisplay = $this->statusList[$incident->status];
        $this->appliedDisplay = $incident->penalty_applied;
        $this->firstLapDisplay = $incident->first_lap;
        $this->displayedStatusId = $incident->status;
        $this->displayedIncidentId = $incident->id;
        $this->displayedPenaltyId = $incident->penalty->id;
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
        $this->showDetails($incident->id);
    }

    public function updatePenaltyOfDisplayed()
    {
        $incident = Incident::find($this->displayedIncidentId);
        $incident->penalty_id = $this->displayedPenaltyId;

        if ($incident->save()) {
            $this->penaltyChangeSuccess = true;
        }

        $this->event->refresh();
        $this->showDetails($incident->id);
    }

    public function requestReview()
    {
        $incident = Incident::find($this->displayedIncidentId);
        $incident->requestReview();

        $this->displayedStatusId = 2;
        $this->statusDisplay = $this->statusList[2];
        $this->event->refresh();
    }

    public function updateReviewersNotes()
    {
        $incident = Incident::find($this->displayedIncidentId);
        $incident->reviewers_notes = $this->displayedReviewerNotes;
        $incident->save();

        $this->reviewNotesUpdateSuccess = true;
        $this->event->refresh();
        $this->showDetails($incident->id); //Duplicate DB Call Caused.
    }

    public function acceptPenalty()
    {
        $this->applyPenalty(true);
    }

    public function applyPenalty($userAccepted = false)
    {
        $incident = Incident::find($this->displayedIncidentId);
        $incident->applyPenalty($userAccepted);

        $this->event->refresh();
        $this->event->recalculatePoints();
        $this->showDetails($incident->id);
    }

    public function render()
    {
        return view('livewire.event-incidents.event-incidents');
    }
}
