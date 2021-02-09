<?php


namespace Tests\Mocks;


use App\Http\Guzzle\Sgp\Get\LeagueViews;
use App\Http\Guzzle\Sgp\SgpApi;

class SgpLeagueViewsMock extends LeagueViews
{
    public function __construct(string $leagueId = null)
    {

    }

    public function get()
    {
        $jsonFile = __DIR__ . '/jsonResponses/LeagueViews.json';
        return json_decode(file_get_contents($jsonFile));
    }
}
