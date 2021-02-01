<?php

namespace App\Pipelines\ImportEventResults;

class CalculatePoints
{
    public function handle(DTO $dto, $next)
    {
        $calculator = new $dto->series->bonus_calculator($dto->eventEntries);
        $calculator->run();

        foreach($dto->eventEntries as $entry) {
            $entry->recalculatePoints();
        }

        return $next($dto);
    }
}
