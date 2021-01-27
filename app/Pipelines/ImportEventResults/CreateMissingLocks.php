<?php

namespace App\Pipelines\ImportEventResults;

use App\Models\SeriesLock;

class CreateMissingLocks
{
    public function handle(DTO $dto, $next)
    {
        if (!$dto->series->splits) return $next($dto);

        foreach ($dto->drivers as $driver) {
            if ($dto->series->hasLockForDriver($driver)) continue;
            SeriesLock::create([
                'driver_id' => $driver->id,
                'series_id' => $dto->series->id,
                'split' => $driver->currentSplit,
                'car_id' => null
            ]);
        }

        return $next($dto);
    }
}
