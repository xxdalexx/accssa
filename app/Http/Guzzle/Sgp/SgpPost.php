<?php

namespace App\Http\Guzzle\Sgp;

use App\Http\Guzzle\Sgp\RequestBuilders\AddDriverToEvent;
use App\Http\Guzzle\Sgp\RequestBuilders\AddDriverToChampionship;

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
            'base_uri' => "https://stg-api.simracing.gp/stg/sessions/$eventId/registerDriver"
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
}
