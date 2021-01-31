<?php

namespace App\Pipelines\ImportEventResults;

class ReassignPositionsForSplit
{
    public function handle(DTO $dto, $next)
    {
        $splits = $dto->eventEntries->groupBy('split');

        foreach ($splits as $split => $entries) {
            if ($split == 'No Score') continue;

            foreach ($entries as $key => $entry) {
                $entry->position = $key + 1;
            }
        }

        return $next($dto);
    }
}
