<?php

namespace App\Pipelines\ImportEventResults;

use App\Models\Event;

class SetEvent
{
    public function handle(DTO $dto, $next)
    {
        $apiResult = $dto->rawApiResult;

        $event = Event::firstOrNew([
            'session_id_sgp' => $apiResult->sessionId,
            'track_name' => $apiResult->trackName,
            'series_id' => $dto->series->id,
        ]);

        //** Dont overwrite session name if it's been set already. */
        $event->session_name = $event->session_name ?? $apiResult->sessionName;

        $event->results_imported = true;
        $event->registration_open = false;

        $event->setRelation('series', $dto->series);

        $dto->setEvent($event);

        return $next($dto);
    }
}
