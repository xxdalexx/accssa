<?php

namespace App\Models;

use App\Concerns\ShowStandings;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Series extends BaseModel
{
    use HasFactory, ShowStandings;

    public static function new(string $name, bool $splits = true, bool $penaltyPoints = true)
    {
        $series = new self;
        $series->name = $name;
        $series->top_point = 0;
        $series->penalty_points = $penaltyPoints;
        $series->splits = $splits;
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

    public function locks()
    {
        return $this->hasMany(SeriesLock::class);
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

    public function linkDropOne()
    {
        return route('series.showDropOne', $this);
    }
}
