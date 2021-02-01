<?php

namespace App\Pipelines\ImportEventResults;

use App\Models\Event;

class SetEvent
{
    public function handle(DTO $dto, $next)
    {
        $results = $dto->results;

        $event = Event::firstOrNew([
            'session_id_sgp' => $results->getSgpSessionId(),
            'track_name' => $results->getTrackName(),
            'series_id' => $dto->series->id,
        ]);

        //** Dont overwrite session name if it's been set already. */
        $event->session_name = $event->session_name ?? $results->getSessionName();

        $event->results_imported = true;
        $event->registration_open = false;

        $event->setRelation('series', $dto->series);

        $dto->setEvent($event);

        return $next($dto);
    }
}
