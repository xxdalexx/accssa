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
}
