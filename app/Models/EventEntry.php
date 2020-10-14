<?php

namespace App\Models;

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
}
