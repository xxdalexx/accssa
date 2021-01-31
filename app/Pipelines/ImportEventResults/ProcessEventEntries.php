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

            $driver = $dto->driverModelFromSgpId($result->driverId);

            $entry->driver_id = $driver->id;
            $entry->position = $result->position;
            $entry->laps = $result->lapCount;
            $entry->quali_time = $dto->qualiTimeForSgpDriver($result->driverId);
            $entry->total_time = $result->totalTime;
            $entry->best_lap = $result->bestCleanLapTime;
            $entry->split = $dto->series->getLockForDriverId($entry->driver_id)->split;

            //** Properties to be set later in the pipe. */
            //$entry->event_id;
            //$entry->race_number;
            //$entry->penalty_points;
            //$entry->best_lap_points;
            //$entry->top_quali_points;
            //$entry->points;
            //$entry->final_points;

            //Fake load relationships.
            $entry->setRelation('driver', $driver);
            $entry->setRelation('event', $dto->event);

            $dto->eventEntries->push($entry);
        }

        return $next($dto);
    }
}
