<?php

namespace App\Observers;

use App\Models\TrackTime;

class TrackTimeObserver
{
    public function created(TrackTime $trackTime)
    {
        if ($trackTime->driver_id === 0) {
            $wheres = [
                ['driver_id', "!=", 0],
                ['sim', $trackTime->sim],
                ['track_id', $trackTime->track_id],
            ];

            $wheres[] = empty($trackTime->car_type)
                ? ['car_id', $trackTime->car_id]
                : ['car_type', $trackTime->car_type];

            $records =  TrackTime::where($wheres)->get();
            $records->each(function (TrackTime $record) {
                $record->lap_time = $record->lap_time;
                $record->save();
            });
        }
    }

    public function updated(TrackTime $trackTime)
    {
        $this->created($trackTime);
    }

    public function deleted(TrackTime $trackTime)
    {
        //
    }

    public function restored(TrackTime $trackTime)
    {
        //
    }

    public function forceDeleted(TrackTime $trackTime)
    {
        //
    }
}
