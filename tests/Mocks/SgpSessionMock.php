<?php


namespace Tests\Mocks;


use App\Http\Guzzle\Sgp\Get\Session;
use App\Http\Guzzle\Sgp\SgpApi;

class SgpSessionMock extends SgpApi
{
    public function get()
    {
        $jsonFile = __DIR__ . '/jsonResponses/Session.json';
        return json_decode(file_get_contents($jsonFile));
    }

    public function setClient(): self
    {
        return $this;
    }

    public function setCacheKey(): self
    {
        return $this;
    }

    public function faked()
    {
        return true;
    }
}
