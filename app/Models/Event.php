<?php

namespace App\Models;

use App\Http\Guzzle\Sgp\SgpBase;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends BaseModel
{
    use HasFactory;

    public static function build($sgpEventId, $seriesId = 1, $minLaps = 20)
    {
        $series = Series::find($seriesId);
        $apiResponse = (new SgpBase)->getEventResults($sgpEventId, $minLaps);

        $event = self::firstOrCreate([
            'session_id_sgp' => $apiResponse['session_id_sgp'],
            'session_name' => $apiResponse['session_name'],
            'track_name' => $apiResponse['track_name'],
            'series_id' => $seriesId
        ]);

        foreach ($apiResponse['raceResults'] as $result) {
            $driver = $result['driverModel'];

            if ($event->series->splits) {
                $lock = SeriesLock::firstOrCreate([
                    'series_id' => $seriesId,
                    'driver_id' => $driver->id
                ]);
                if ($lock->wasRecentlyCreated) {
                    $lock->split = $driver->calculateDriverScore()->currentSplit;
                    $lock->save();
                }
            }

            $entry = EventEntry::firstOrCreate([
                'event_id' => $event->id,
                'driver_id' => $result['driver_id'],
                'position' => $result['position'],
                'quali_time' => $result['quali_time'],
                'laps' => $result['laps'],
                'total_time' => $result['total_time'],
                'best_lap' => $result['best_lap'],
                'best_lap_points' => $result['best_lap_points'],
                'top_quali_points' => $result['top_quali_points'],
                'split' => $lock->split ?? ''
            ]);
        }

        if ($event->series->splits) {
            $event->repositionSplits();
        } else {
            //If the new driver count is higher than previous, all events in the series will
            //have their points recalculated. If not, calculate points for this event alone.
            if (!$event->series->topPointUpdate(count($apiResponse['raceResults']))) {
                $event->recalculatePoints();
            }
        }

        return $event;
    }

    public function repositionSplits()
    {
        $splits = $this->eventEntries->groupBy('split');

        $this->repositionSplit($splits, 'Pro');
        $this->repositionSplit($splits, 'Silver');
        $this->repositionSplit($splits, 'AM');

        if (property_exists($splits, 'No Score')) {
            foreach ($splits['No Score'] as $entry) {
                $entry->position = 0;
                $entry->points = 0;
                $entry->save();
            }
        }
    }

    protected function repositionSplit($splits, $splitName)
    {
        $counter = 1;
        $points = 20;
        foreach ($splits[$splitName] as $entry) {
            $entry->position = $counter;
            $entry->points = $points;
            $entry->final_points = $entry->points + $entry->best_lap_points + $entry->top_quali_points - $entry->penalty_points;
            $entry->save();
            $counter++;
            $points--;
        }
    }

    public function recalculatePoints()
    {
        if ($this->series->splits) {
            $this->repositionSplits();
        } else {
            $this->recalculatePointsNoSplits();
        }
    }

    protected function recalculatePointsNoSplits()
    {
        $top = $this->series->top_point + 1;
        foreach ($this->eventEntries as $entry) {
            $entry->points = $top - $entry->position;
            $entry->final_points = $entry->points + $entry->best_lap_points + $entry->top_quali_points - $entry->penalty_points;
            $entry->save();
        }
    }

    protected function recalculatePointsWithSplits()
    {
        $entries = $this->eventEntries->groupBy('split');
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
            $drivers['driver' . $entry->driver->id] = $entry->driver->displayNameReversed;
        }
        return $drivers;
    }

    public function link()
    {
        return route('event.show', $this);
    }
}
