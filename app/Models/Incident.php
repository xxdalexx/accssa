<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Incident extends BaseModel
{
    use HasFactory;

    public function accused()
    {
        return $this->belongsTo(Driver::class, 'accused_id')->withDefault([
            'driver_name' => "I'm a bug."
        ]);
    }

    public function victim()
    {
        return $this->belongsTo(Driver::class, 'victim_id')->withDefault([
            'driver_name' => "I'm a bug."
        ]);
    }

    public function reportedBy()
    {
        return $this->belongsTo(User::class, 'reported_by_id');
    }

    public function penalty()
    {
        return $this->belongsTo(Penalty::class)->withDefault([
            'displayName' => "I'm a bug."
        ]);
    }

    public function applyPenalty($userAccepted = false)
    {
        $eventEntry = EventEntry::where(['event_id' => $this->event_id, 'driver_id' => $this->accused_id])->first();

        $eventEntry->penalty_points += $this->penalty->points;
        if ($this->first_lap) {
            $eventEntry->penalty_points += $this->penalty->points; //Apply again if first lap
        }
        $eventEntry->save();

        $this->penalty_applied = true;

        if ($userAccepted) {
            $this->status = 1;
        }

        $this->save();
    }

    public function requestReview()
    {
        $this->status = 2;
        $this->save();
    }
}
