<?php

namespace App\Http\Guzzle\Sgp;

use App\Http\Guzzle\Sgp\RequestBuilders\AddDriverToEvent;
use App\Http\Guzzle\Sgp\RequestBuilders\AddDriverToChampionship;
use App\Http\Guzzle\Sgp\RequestBuilders\RemoveDriverFromEvent;

class SgpPost extends SgpBase
{
    public function rejectApplication($id)
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => "https://stg-api.simracing.gp/stg/command/participant-application/RejectApplication/$id/1"
        ]);

        return $this->getResponse('POST');
    }

    public function addDriverToEvent(string $eventId, AddDriverToEvent $request)
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => "https://stg-api.simracing.gp/stg/command/entry-list/AddEntry/$eventId/3"
        ]);

        $this->params['body'] = $request->getRequestJson();

        return $this->getResponse('POST');
    }

    public function addDriverToChampionship(AddDriverToChampionship $request)
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => "https://stg-api.simracing.gp/stg/tournaments/command"
        ]);

        $this->params['body'] = $request->getRequestJson();

        return $this->getResponse('POST');
    }

    public function unregisterDriverFromEvent(string $eventId, RemoveDriverFromEvent $request)
    {
        $this->client = new \GuzzleHttp\Client(['base_uri' => "https://stg-api.simracing.gp/stg/sessions/$eventId/unregisterDriver"]);

        $this->params['body'] = $request->getRequestJson();

        return $this->getResponse('POST');
    }
}
