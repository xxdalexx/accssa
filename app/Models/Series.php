<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Series extends BaseModel
{
    use HasFactory;

    public static function new(string $name)
    {
        $series = new self;
        $series->name = $name;
        $series->top_point = 0;
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

    public function getStandings()
    {
        $points = [];

        $drivers = $this->eventEntries->groupBy('driver_id');

        foreach ($drivers as $driver) {
            foreach ($driver as $entry) {
                if (!isset($points[$entry->driver->driver_name])) {
                    $points[$entry->driver->driver_name] = 0;
                }
                $points[$entry->driver->driver_name] += $entry->final_points;
            }
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
}
