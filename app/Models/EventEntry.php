<?php

namespace App\Models;

use App\Helper\RaceTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventEntry extends BaseModel
{
    use HasFactory;

    protected $with = ['driver'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function recalculatePoints($top = 20, $splitPosition = null)
    {
        $position = $splitPosition ?? $this->position;
        $top = $top ?? $this->event->series->top_point;//TODO: Currently hard coded to 20, needs rethought.

        $this->points = $top + 1 - $position;
        $this->final_points = $this->points + $this->best_lap_points + $this->top_quali_points - $this->penalty_points;
        return $this;
    }

    public function getPenaltyPointsAttribute($value)
    {
        if ($value == 0) {
            return;
        }
        return $value;
    }

    public function getBestLapPointsAttribute($value)
    {
        if ($value == 0) {
            return;
        }
        return $value;
    }

    public function getTopQualiPointsAttribute($value)
    {
        if ($value == 0) {
            return;
        }
        return $value;
    }

    public function getQualiTimeTextAttribute()
    {
        $raceTime = new RaceTime($this->quali_time);
        return $raceTime->onlySeconds();
    }

    public function getBestLapTextAttribute()
    {
        $raceTime = new RaceTime($this->best_lap);
        return $raceTime->onlySeconds();
    }

    public function getTotalTimeTextAttribute()
    {
        $raceTime = new RaceTime($this->total_time);
        return $raceTime->withHour();
    }

    public function setQualiTimeAttribute($value)
    {
        if (is_null($value)) {
            $this->attributes['quali_time'] = 0;
        } else {
            $this->attributes['quali_time'] = $value;
        }
    }

    public function applyPenalty($points, $doubled = false)
    {
        $this->penalty_points += $points;

        if ($doubled) {
            $this->penalty_points += $points;
        }

        $this->save();
    }
}
