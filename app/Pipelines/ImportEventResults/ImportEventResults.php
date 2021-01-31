<?php

namespace App\Pipelines\ImportEventResults;

use App\Models\Series;
use App\Pipelines\ImportEventResults\DTO;
use App\EventBonusCalculators\OnePointEachSplit;

class ImportEventResults
{
    protected static array $pipes = [
        MakeApiCall::class,
        NewEvent::class,
        HandleDrivers::class,
        CreateMissingLocks::class,
        ProcessEventEntries::class,
        ReassignPositionsForSplit::class,
        CalculatePoints::class,
        SaveAll::class
    ];

    public static function get(string $eventId, Series $series, int $minLapCutoff = 20):DTO
    {
        $series->bonus_calculator = OnePointEachSplit::class; //Make Dynamic In DB

        $passable = new DTO($eventId, $series, $minLapCutoff);

        return app('Illuminate\Pipeline\Pipeline')
            ->send($passable)
            ->through(static::$pipes)
            ->thenReturn();
    }
}
