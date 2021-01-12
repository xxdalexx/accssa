<?php

namespace App\Models;

use App\Concerns\ShowStandings;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Series extends BaseModel
{
    use HasFactory, ShowStandings;

    public static function new(string $name, bool $splits = true, bool $penaltyPoints = true, bool $registrationLocked = false, bool $dropOne = false)
    {
        $series = new self;
        $series->name = $name;
        $series->top_point = 0;
        $series->penalty_points = $penaltyPoints;
        $series->splits = $splits;
        $series->registration_locked = $registrationLocked;
        $series->drop_one_standings = $dropOne;
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

    public function registrationStatusHtml()
    {
        if ($this->registration_open) {
            return '<span class="text-success">Open</span>';
        }
        return '<span class="text-danger">Closed</span>';
    }

    public function sgpEventIds()
    {
        $ids = [];
        foreach ($this->events as $event) {
            $ids[] = $event->session_id_sgp;
        }
        return $ids;
    }

    public function hasLockForDriver(Driver $driver)
    {
        return $this->locks->contains('driver_id', $driver->id);
    }

    public function hasLockForUser(User $user)
    {
        return $this->hasLockForDriver($user->driver);
    }

    public function getLockForDriver(Driver $driver)
    {
        return $this->locks->firstWhere('driver_id', $driver->id);
    }

    public function getLockForUser(User $user)
    {
        return $this->getLockForDriver($user->driver);
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
