<?php

namespace App\Concerns;

trait ShowStandings
{
    public function getStandings($dropOne = false)
    {
        if ($this->splits && $dropOne) {
            return $this->getStandingsForSplitsDropOne();
        }

        if ($this->splits) {
            return $this->getStandingsForSplits();
        }

        if ($dropOne) {
            return $this->getStandingsDropOne();
        }
        return $this->getStandingsRegular();
    }

    protected function getStandingsForSplits()
    {
        $points = [];

        $splits = $this->eventEntries->groupBy('split');

        foreach ($splits as $splitName => $entries) {
            $splitPoints = [];
            $drivers = $entries->groupBy('driver_id');
            foreach ($drivers as $driver) {
                $splitPoints[$driver->first()->driver->driver_name] = $driver->sum('final_points');
            }
            arsort($splitPoints);
            $points[$splitName] = $this->cutStandingsArrayInTwo($splitPoints);
        }

        return $points;
    }

    protected function getStandingsForSplitsDropOne()
    {
        $points = [];
        $eventsCount = $this->events()->count();
        $splits = $this->eventEntries()->select(['driver_id', 'final_points', 'split'])->get()->groupBy('split');

        foreach ($splits as $splitName => $entries) {
            $splitPoints = [];
            $drivers = $entries->groupBy('driver_id');

            foreach ($drivers as $driver) {
                if ($driver->count() == $eventsCount && $driver->count() != 1) {
                    $driver = $driver->sortByDesc('final_points');
                    $driver->pop();
                }
                $splitPoints[$driver->first()->driver->driver_name] = $driver->sum('final_points');
            }
            arsort($splitPoints);
            $points[$splitName] = $this->cutStandingsArrayInTwo($splitPoints);
        }

        return $points;
    }

    protected function getStandingsDropOne()
    {
        $points = [];
        $eventsCount = $this->events()->count();
        $drivers = $this->eventEntries()->select(['driver_id', 'final_points'])->get()->groupBy('driver_id');

        foreach ($drivers as $driver) {
            if ($driver->count() == $eventsCount && $driver->count() != 1) {
                $driver = $driver->sortByDesc('final_points');
                $driver->pop();
            }
            $points[$driver->first()->driver->driver_name] = $driver->sum('final_points');
        }

        arsort($points);
        return $this->cutStandingsArrayInTwo($points);
    }

    protected function getStandingsRegular()
    {
        $points = [];

        $drivers = $this->eventEntries->groupBy('driver_id');

        foreach ($drivers as $driver) {
            $points[$driver->first()->driver->driver_name] = $driver->sum('final_points');
        }

        arsort($points);
        return $this->cutStandingsArrayInTwo($points);
    }

    protected function emptyStandings()
    {
        $array[0] = ['No Current Standings' => 0];
        $array[1] = ['No Current Standings' => 0];
        return $array;
    }

    protected function cutStandingsArrayInTwo(array $input)
    {
        $points = collect($input);
        $cut = $points->split(2);

        if (!$cut->count()) {
            return $this->emptyStandings();
        }

        return $cut->toArray();
    }
}
