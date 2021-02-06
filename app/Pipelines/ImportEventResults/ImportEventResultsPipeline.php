<?php

namespace App\Pipelines\ImportEventResults;

use App\Models\Event;
use App\Models\Series;
use App\Pipelines\ImportEventResults\DTO;
use App\EventBonusCalculators\OnePointEachSplit;

class ImportEventResultsPipeline
{
    protected static array $pipes = [
        MakeApiCall::class,
        SetEvent::class,
        HandleDrivers::class,
        CreateMissingLocks::class,
        ProcessEventEntries::class,
        ReassignPositionsForSplit::class,
        CalculatePoints::class,
        SaveAll::class
    ];

    public static function run(string $eventId, Series $series, int $minLapCutoff = 20):Event
    {
        $series->bonus_calculator = OnePointEachSplit::class; //Make Dynamic In DB

        $passable = new DTO($eventId, $series, $minLapCutoff);

        $finalDTO = app('Illuminate\Pipeline\Pipeline')
            ->send($passable)
            ->through(static::$pipes)
            ->thenReturn();

        return $finalDTO->event;
    }
}
