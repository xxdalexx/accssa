<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Series extends BaseModel
{
    use HasFactory;

    public static function new(string $name, bool $penaltyPoints = false)
    {
        $series = new self;
        $series->name = $name;
        $series->top_point = 0;
        $series->penalty_points = $penaltyPoints;
        $series->save();
        return $series;
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function eventEntries()
    {
        return $this->hasManyThrough(EventEntry::class, Event::class);
    }

    public function getStandingsDropOne()
    {
        $points = [];
        $eventsCount = $this->events()->count();
        $drivers = $this->eventEntries()->select(['driver_id', 'final_points'])->get()->groupBy('driver_id');

        foreach ($drivers as $driver) {
            if ($driver->count() == $eventsCount) {
                $driver = $driver->sortByDesc('final_points');
                $driver->pop();
            }
            $points[$driver->first()->driver->driver_name] = $driver->sum('final_points');
        }

        arsort($points);
        return $points;
    }

    public function getStandings()
    {
        $points = [];

        $drivers = $this->eventEntries->groupBy('driver_id');

        foreach ($drivers as $driver) {
            $points[$driver->first()->driver->driver_name] = $driver->sum('final_points');
        }

        arsort($points);
        return $points;
    }

    public function recalculateAllEventPoints()
    {
        foreach ($this->events as $event) {
            $event->recalculatePoints();
        }
    }

    public function topPointUpdate(int $points)
    {
        if ($points <= $this->top_point) {
            return false;
        }
        $this->top_point = $points;
        $this->save();
        $this->recalculateAllEventPoints();
    }

    public function link()
    {
        return route('series.show', $this);
    }
}
