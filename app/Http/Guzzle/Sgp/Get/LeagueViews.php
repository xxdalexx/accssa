<?php


namespace App\Http\Guzzle\Sgp\Get;


use App\Http\Guzzle\Sgp\SgpApi;
use App\Models\Site;

class LeagueViews extends SgpApi
{
    protected string $leagueId;

    public function __construct(string $leagueId = null)
    {
        $this->leagueId = $leagueId ?? Site::sgpLeagueId();

        parent::__construct();
    }

    protected function setClient(): self
    {
        $this->client = new \GuzzleHttp\Client(['base_uri' => "https://stg-api.simracing.gp/stg/league-views/$this->leagueId"]);

        return $this;
    }

    protected function setCacheKey(): self
    {
        // No Caching
        return $this;
    }
}
