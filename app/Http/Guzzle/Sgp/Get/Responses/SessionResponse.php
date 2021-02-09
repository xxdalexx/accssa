<?php


namespace App\Http\Guzzle\Sgp\Get\Responses;


use App\Http\Guzzle\Sgp\Get\Session;
use App\Http\Guzzle\Sgp\SgpApi;

class SessionResponse
{
    protected $rawResponse;

    public function forEvent(string $eventId)
    {
        $this->rawResponse = app(Session::class)
            ->forEvent($eventId)
            ->get();

        return $this;
    }

    public function getRawResponse()
    {
        return $this->rawResponse;
    }
}
