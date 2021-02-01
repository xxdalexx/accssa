<?php

namespace App\Pipelines\ImportEventResults;

use App\Models\Driver;

class HandleDrivers
{
    public function handle(DTO $dto, $next)
    {
        $dto->loadDrivers();

        foreach ($dto->missingDrivers() as $neededDriverId) {
            $newDriver = Driver::importFromSgp($neededDriverId);
            $dto->drivers->push($newDriver);
        }

        return $next($dto);
    }
}
