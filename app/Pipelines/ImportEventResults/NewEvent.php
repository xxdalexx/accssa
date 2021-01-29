<?php

namespace App\Pipelines\ImportEventResults;

use App\Models\Event;

class NewEvent
{
    public function handle(DTO $dto, $next)
    {
        $event = new Event;
        $apiResult = $dto->rawApiResult;

        $event->session_id_sgp = $apiResult->sessionId;
        $event->session_name = $apiResult->sessionName;
        $event->track_name = $apiResult->trackName;
        $event->series_id = $dto->series->id;
        $event->results_imported = true;
        $event->registration_open = $dto->series->registration_open; //I don't think this is needed.
        //$event->replay_url;

        $dto->setEvent($event);

        return $next($dto);
    }
}
