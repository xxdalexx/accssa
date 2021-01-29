<?php

namespace App\Pipelines\ImportEventResults;

class SaveAll
{
    public function handle(DTO $dto, $next)
    {
        $dto->event->save();
        $eventId = $dto->event->id;

        foreach ($dto->eventEntries as $eventEntry) {
            $eventEntry->event_id = $eventId;
            $eventEntry->save();
        }

        return $next($dto);
    }
}
