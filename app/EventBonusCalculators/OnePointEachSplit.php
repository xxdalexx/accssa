<?php

namespace App\EventBonusCalculators;

use Illuminate\Support\Collection;

class OnePointEachSplit
{
    protected Collection $eventEntries;

    protected Collection $modified;

    protected bool $save;

    public function __construct(Collection $eventEntries, $save = false)
    {
        $this->eventEntries = $eventEntries;
        $this->modified = collect();
        $this->save = $save;
    }

    public function run()
    {
        $splits = $this->eventEntries->groupBy('split');
        foreach ($splits as $split => $entries) {
            if ($split == "No Score") continue;

            $this->setQualiBonus($entries);
            $this->setFastestLapBonus($entries);
        }

        if ($this->save) {
            $this->modified->unique()->each->save();
        }
    }

    protected function setQualiBonus(Collection $splitEntries)
    {
        $entry = $splitEntries->sortBy('quali_time')->first();
        $entry->top_quali_points = 1;

        $this->modified->push($entry);
    }

    protected function setFastestLapBonus(Collection $splitEntries)
    {
        $entry = $splitEntries->sortBy('best_lap')->first();
        $entry->best_lap_points = 1;

        $this->modified->push($entry);
    }
}
