<?php


namespace App\Http\Guzzle\Sgp\Get\Responses;


use App\Http\Guzzle\Sgp\Get\LeagueViews;
use App\Http\Guzzle\Sgp\Get\SgpApiContract;
use App\Http\Guzzle\Sgp\SgpApi;
use Illuminate\Support\Collection;

class LeagueViewsResponse
{
    protected $rawResponse;

    public function __construct(SgpApi $caller)
    {
        $this->rawResponse = $caller->get();
    }

    public function getRawResponse(): \stdClass
    {
        return $this->rawResponse;
    }

    public function memberList(): ?Collection
    {
        return collect($this->rawResponse->members) ?? null;
    }

    public function findMemberByDiscordId(string $discordUserId)
    {
        return $this->memberList()->firstWhere('discord.id', $discordUserId);
    }

    public function findMemberBySgpId(string $sgpId)
    {
        return $this->memberList()->firstWhere('userId', $sgpId);
    }
}
