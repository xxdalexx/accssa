<?php

namespace App\Pipelines\ImportEventResults;

use App\Models\EventEntry;

class ProcessEventEntries
{
    public function handle(DTO $dto, $next)
    {
        $results = $dto->getFirstRaceResults();

        foreach ($results as $result) {
            if ($result->lapCount < $dto->minLapCutoff) continue;
            $entry = new EventEntry;

            $entry->driver_id = $dto->driverIdFromSgpId($result->driverId);
            //$entry->event_id; Later
            $entry->position = $result->position;
            $entry->laps = $result->lapCount;
            $entry->quali_time = $dto->qualiTimeForSgpDriver($result->driverId);
            $entry->total_time = $result->totalTime;
            $entry->best_lap = $result->bestCleanLapTime;
            //$entry->race_number;
            //$entry->penalty_points;
            //$entry->best_lap_points;
            //$entry->top_quali_points;
            //$entry->points;
            //$entry->final_points;
            $entry->split = $dto->series->getLockForDriverId($entry->driver_id)->split;

            $dto->eventEntries->push($entry);
        }

        return $next($dto);
    }
}
