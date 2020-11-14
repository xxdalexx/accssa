<?php

namespace App\Models;

use App\Http\Guzzle\Sgp\SgpBase;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends BaseModel
{
    use HasFactory;

    public static function build($sgpEventId, $seriesId = 1, $minLaps = 20)
    {
        $apiResponse = (new SgpBase)->getEventResults($sgpEventId, $minLaps);

        $event = self::firstOrCreate([
            'session_id_sgp' => $apiResponse['session_id_sgp'],
            'session_name' => $apiResponse['session_name'],
            'track_name' => $apiResponse['track_name'],
            'series_id' => $seriesId
        ]);

        foreach ($apiResponse['raceResults'] as $result) {
            EventEntry::firstOrCreate([
                'event_id' => $event->id,
                'driver_id' => $result['driver_id'],
                'position' => $result['position'],
                'quali_time' => $result['quali_time'],
                'laps' => $result['laps'],
                'total_time' => $result['total_time'],
                'best_lap' => $result['best_lap'],
                'best_lap_points' => $result['best_lap_points'],
                'top_quali_points' => $result['top_quali_points']
            ]);
        }

        //If the new driver count is higher than previous, all events in the series will
        //have their points recalculated. If not, calculate points for this event alone.
        if (!$event->series->topPointUpdate(count($apiResponse['raceResults']))) {
            $event->recalculatePoints();
        }

        return $event;
    }

    public function recalculatePoints()
    {
        $top = $this->series->top_point + 1;
        foreach ($this->eventEntries as $entry) {
            $entry->points = $top - $entry->position;
            $entry->final_points = $entry->points + $entry->best_lap_points + $entry->top_quali_points - $entry->penalty_points;
            $entry->save();
        }
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function eventEntries()
    {
        return $this->hasMany(EventEntry::class);
    }

    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }

    public function getDriverList(): array
    {
        $drivers = [];
        foreach($this->eventEntries as $entry) {
            $drivers[$entry->driver->id] = $entry->driver->displayNameReversed;
        }
        return $drivers;
    }

    public function link()
    {
        return route('event.show', $this);
    }
}
