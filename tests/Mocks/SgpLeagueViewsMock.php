<?php


namespace Tests\Mocks;


use App\Http\Guzzle\Sgp\SgpApi;

class SgpLeagueViewsMock extends \App\Http\Guzzle\Sgp\SgpApi
{
    public function __construct()
    {
    }

    protected function setClient(): \App\Http\Guzzle\Sgp\SgpApi
    {
        return $this;
    }

    protected function setCacheKey(): \App\Http\Guzzle\Sgp\SgpApi
    {
        return $this;
    }

    public function get()
    {
        $jsonFile = __DIR__ . '/jsonResponses/LeagueViews.json';
        return json_decode(file_get_contents($jsonFile));
    }
}
