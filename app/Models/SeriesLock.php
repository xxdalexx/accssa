<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class SeriesLock extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function seriesEventEntries()
    {
        return $this->series->eventEntries()->whereDriverId($this->driver_id)->with('event')->get();
    }

    public function overrideSplit($split)
    {
        $this->split = $split;
        $this->save();

        foreach ($this->seriesEventEntries() as $entry) {
            $entry->split = $split;
            $entry->save();
            $entry->event->recalculatePoints();
        }

        return $this;
    }
}
