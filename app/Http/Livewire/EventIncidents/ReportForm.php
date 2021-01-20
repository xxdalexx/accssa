<?php


namespace App\Http\Livewire\EventIncidents;

use App\Models\Incident;
use App\Models\EventEntry;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

trait ReportForm
{
    public $formInputs = [
        'penaltyId' => "0",
        'accusedId' => "0",
        'victimId' => "0",
        'timestamp' => "",
        'description' => "",
        'firstLap' => "0"
    ];

    public function newIncident()
    {
        $accusedId = (int) Str::after($this->formInputs['accusedId'], 'driver');
        $victimId = (int) Str::after($this->formInputs['victimId'], 'driver');

        $incident = Incident::create([
            'accused_id' => $accusedId,
            'victim_id' => $victimId,
            'reported_by_id' => Auth::id(),
            'penalty_id' => $this->formInputs['penaltyId'],
            'event_id' => $this->event->id,
            'timestamp' => $this->formInputs['timestamp'],
            'description' => $this->formInputs['description'],
            'reviewers_notes' => 'Not reviewed',
            'first_lap' => $this->formInputs['firstLap'],
            'status' => 0,
        ]);

        //Self Reported
        if (Auth::user()->driver->id == (int) $accusedId) {
            $incident->applyPenalty(true);
        }

        $this->event->refresh();
        $this->resetAllFields();
    }

    public function resetAllFields()
    {
        $this->formInputs['penaltyId'] = "1";
        $this->formInputs['accusedId'] = "0";
        $this->formInputs['victimId'] = "0";
        $this->formInputs['timestamp'] = "";
        $this->formInputs['description'] = "";
        $this->formInputs['firstLap'] = "0";
    }
}
